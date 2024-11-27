<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Decor extends Model
{
    /** @use HasFactory<\Database\Factories\DecorFactory> */
    use HasFactory;

	protected $fillable = [
		"name",
		"file_path",
		"start_use",
		"end_use",
		"event_id",
	];

	public function toArray()
	{
		$data = parent::toArray();
		$data["created_at_fr"] = Carbon::parse($data["created_at"])->format("d/m/yy H:i:s");
		$data["updated_at_fr"] = Carbon::parse($data["updated_at"])->format("d/m/yy H:i:s");
		return $data;
	}

	public function event(): BelongsTo{
		return $this->belongsTo(Event::class, "event_id", "id");
	}
}
