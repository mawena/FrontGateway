<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
		"validation",
		"user_id",
		"nb_use",
	];

	public $appends = ["days_remaining", "short_name"];

	public function toArray()
	{
		$data = parent::toArray();
		$data["start_use_fr"] = Carbon::parse($data["start_use"])->format("d/m/Y");
		$data["end_use_fr"] = Carbon::parse($data["end_use"])->format("d/m/Y");
		$data["created_at_fr"] = Carbon::parse($data["created_at"])->format("d/m/Y H:i:s");
		$data["updated_at_fr"] = Carbon::parse($data["updated_at"])->format("d/m/Y H:i:s");
		return $data;
	}

	public function event(): BelongsTo
	{
		return $this->belongsTo(Event::class, "event_id", "id");
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function getDaysRemainingAttribute()
	{
		$dateNow = Carbon::now();
		$diff = $dateNow->diff(Carbon::parse($this->end_use));
		$return = "";
		$return .= $diff->y ? "$diff->y an(s) et " : "";
		$return .= $diff->m ? "$diff->m moi(s) et " : "";
		$return .= $diff->d ? "$diff->d jour(s)" : "";

		if (Str::endsWith($return, 'et ')) {
			$result = Str::beforeLast($return, 'et ');
		}
		return $return;
	}

	public function getShortNameAttribute()
	{
		return substr($this->name, 0, 50) . (strlen($this->name) > 50 ? "..." : "");
	}
}
