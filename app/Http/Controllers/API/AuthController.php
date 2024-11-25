<?php

namespace App\Http\Controllers\API;

use App\Http\Traits\CustomResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @group Authentification
 *
 * EndPoints pour gérer l'authentification
 */
class AuthController extends Controller
{
	use CustomResponseTrait;

	/**
	 * Connecte un utilisateur
	 *
	 * @bodyParam email			string		required	L'email de l'utilsateur.						Example: admin@pecorator.com
	 * @bodyParam password		string		required	Le mot de passe complet de l'utilisateur.		Example: azerty
	 *
	 * @response 200
	 */
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|exists:users',
			"password" => 'required'
		]);
		if ($validator->fails()) {
			return $this->responseError($validator->errors()->toArray(), 400);
		}

		$user = User::where('email', $request->email)->first();
		if (Hash::check($request->password, $user->password)) {
			return $this->responseOk([
				"userToken" => $user->createToken($request->email)->plainTextToken,
				"user" => $user,
			]);
		} else {
			return $this->responseError(["password" => ["Mot de passe incorrect"]], 400);
		}
	}

	/**
	 * Affiche l'utilisateur connecté
	 *
	 * @response 200
	 */
	public function show(Request $request, int $id)
	{
		return $this->responseOk($request->user());
	}

	/**
	 * Déconnecte l'utilisateur connecté
	 *
	 * @response 204
	 */
	public function logout(Request $request)
	{
		if ($request->user()->currentAccessToken()->delete()) {
			return $this->responseOk(["messages" => ["logout done"]]);
		} else {
			return $this->responseError(["errors" => ["error during logout"]]);
		}
	}
}
