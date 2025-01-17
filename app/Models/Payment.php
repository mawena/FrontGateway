<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
	/** @use HasFactory<\Database\Factories\PaymentFactory> */
	use HasFactory;

	protected $fillable = [
		"user_id",
		"nb_uses",
		"amount",
		"currency",
		"description",
		"status",
		"phone_number",
		"payment_url",
		"payment_token",
		"transaction_id",
	];

	public $appends = ["status_fr"];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, "user_id", "id");
	}

	public function toArray()
	{
		$data = parent::toArray();
		$data["created_at_fr"] = Carbon::parse($data["created_at"])->format("d/m/Y H:i:s");
		$data["updated_at_fr"] = Carbon::parse($data["updated_at"])->format("d/m/Y H:i:s");
		return $data;
	}

	public function getStatusFrAttribute(){
		return [
			"initiated" => "Initié",
			"in-progress" => "En cours de traitement",
			"validated" => "Validé",
			"rejected" => "Rejeté",
			"error" => "Erreur !"
		][$this->status];
	}
}
