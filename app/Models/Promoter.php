<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Promoter extends Model
{
	/** @use HasFactory<\Database\Factories\PromoterFactory> */
	use HasFactory;

	protected $fillable = [
		"structure",
		"phone_number",
		"birth_date",
		"sex",
		"user_id",
	];

	public function toArray()
	{
		$data = parent::toArray();
		$data["created_at_fr"] = Carbon::parse($data["created_at"])->format("d/m/yy H:i:s");
		$data["updated_at_fr"] = Carbon::parse($data["updated_at"])->format("d/m/yy H:i:s");
		return $data;
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, "user_id", "id");
	}

}
