<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProjectController
{
    public function handleProject(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:download,transfer,delete',
            'project_path' => 'required|string',
            'target_server' => 'nullable|string',
            'target_path' => 'nullable|string',
            'target_port' => 'nullable|string',
        ]);

        $projectPath = $validated['project_path'];
        $action = $validated['action'];

        switch ($action) {
            case 'download':
                return $this->downloadProject($projectPath);

            case 'transfer':
                return $this->transferProject($projectPath, $validated['target_server'], $validated['target_path'], $validated['target_port']);

            case 'delete':
                return $this->deleteProject($projectPath);

            default:
                return response()->json(['message' => 'Action non reconnue.'], 400);
        }
    }

    private function downloadProject($projectPath)
    {
        if (!file_exists($projectPath)) {
            return response()->json(['message' => 'Projet non trouvé.'], 404);
        }

        $zipPath = storage_path('app/temp_project.zip');
        $process = new Process(['zip', '-r', $zipPath, $projectPath]);

        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function transferProject($projectPath, $targetServer, $targetPath, $targetPort)
    {
        if (!file_exists($projectPath)) {
            return response()->json(['message' => 'Projet non trouvé.'], 404);
        }

        if (empty($targetServer) || empty($targetPath)) {
            return response()->json(['message' => 'Cible invalide pour le transfert.'], 400);
        }

		$zipPath = storage_path('app/temp_project.zip');
        $process = new Process(['zip', '-r', $zipPath, $projectPath]);

		$process->setTimeout(3000);

        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $process = new Process(['scp', '-P', $targetPort, $zipPath, "{$targetServer}:{$targetPath}"]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(['message' => 'Projet transféré avec succès.']);
    }

    private function deleteProject($projectPath)
    {
        if (!file_exists($projectPath)) {
            return response()->json(['message' => 'Projet non trouvé.'], 404);
        }

        $process = new Process(['rm', '-rf', $projectPath]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(['message' => 'Projet supprimé avec succès.']);
    }
}
