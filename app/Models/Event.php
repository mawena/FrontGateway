<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Event extends Model
{
	/** @use HasFactory<\Database\Factories\EventFactory> */
	use HasFactory;

	protected $fillable = [
		"name",
		"start_date",
		"end_date",
		"promoter_id",
		"place",
		"type",
		"nb_expected",
		"entrance",
		"entry_price",
		"contact",
		"description",
		"description_summary",
		"poster_path",
		"validation",
	];

	public function toArray()
	{
		$data = parent::toArray();
		$data["created_at_fr"] = Carbon::parse($data["created_at"])->format("d/m/yy H:i:s");
		$data["updated_at_fr"] = Carbon::parse($data["updated_at"])->format("d/m/yy H:i:s");
		$data["start_date_fr"] = Carbon::parse($data["start_date"])->format("d/m/yy H:i:s");
		$data["end_date_fr"] = Carbon::parse($data["end_date"])->format("d/m/yy H:i:s");
		return $data;
	}

	public function promoter(): BelongsTo
	{
		return $this->belongsTo(Promoter::class, 'promoter_id', 'id');
	}

	public function decors(): HasMany
	{
		return $this->hasMany(Decor::class, "event_id", "id");
	}
}
