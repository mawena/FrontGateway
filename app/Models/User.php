<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	/** @use HasFactory<\Database\Factories\UserFactory> */
	use HasApiTokens, HasFactory, Notifiable;

	protected $appends = ['ability_rules', 'profile_fr'];


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'profile',
		'picture_path',
		'activated',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'password' => 'hashed',
		];
	}

	public function promoter(): HasOne
	{
		return $this->hasOne(Promoter::class, "user_id", "id");
	}
	public function events(): HasMany
	{
		return $this->hasMany(Event::class, 'user_id', 'id');
	}
	public function decors(): HasMany
	{
		return $this->hasMany(Decor::class, 'promoter_id', 'id');
	}
	public function payments(): HasMany
	{
		return $this->hasMany(Payment::class, "user_id", "id");
	}

	public function toArray()
	{
		$data = parent::toArray();
		$data["created_at_fr"] = Carbon::parse($data["created_at"])->format("d/m/Y H:i:s");
		$data["updated_at_fr"] = Carbon::parse($data["updated_at"])->format("d/m/Y H:i:s");
		$data["activated"] = (bool) $data["activated"];
		$data["picture_path"] = ($data["picture_path"]) ?? "pictures/users/default.png";
		return $data;
	}
	public function getProfileFrAttribute()
	{
		return [
			'admin' => 'Administrateur',
			'supervisor' => 'Superviseur',
			'money_manager' => 'Gestionnaire de paiement',
			'event_planner' => 'Planificateur d\'evenement',
			'promoter' => 'Promoteur',
			'visitor' => 'Visiteur',
		][$this->profile];
	}
	public function getAbilityRulesAttribute()
	{
		return [
			'admin' => [
				[
					'action' => ['manage'],
					'subject' => ['all'],
				],
			],
			'supervisor' => [
				[
					'action' => ['read'],
					'subject' => ['user', 'promoter', 'event', 'decor', 'payment', 'supervisor', 'backofficier', 'settings-user']
				],
				[
					'action' => ['create'],
					'subject' => ['user', 'promoter', 'event', 'decor', 'supervisor']
				],
				[
					'action' => ['edit'],
					'subject' => ['promoter', 'event', 'decor', 'supervisor']
				],
				[
					'action' => ['update_password'],
					'subject' => ['user']
				],
				[
					'action' => ['reject'],
					'subject' => ['event', 'decor']
				],
				[
					'action' => ['validate'],
					'subject' => ['event', 'decor']
				],
				[
					'action' => ['delete'],
					'subject' => ['user', 'promoter', 'event', 'decor']
				],
			],
			'money_manager' => [
				[
					'action' => ['read'],
					'subject' => ['user', 'promoter', 'event', 'decor', 'payment', 'settings-user']
				],
				[
					'action' => ['create'],
					'subject' => []
				],
				[
					'action' => ['edit'],
					'subject' => []
				],
				[
					'action' => ['update_password'],
					'subject' => ['user']
				],
				[
					'action' => ['reject'],
					'subject' => ['payment']
				],
				[
					'action' => ['validate'],
					'subject' => ['payment']
				],
				[
					'action' => ['delete'],
					'subject' => []
				],
			],
			'event_planner' => [
				[
					'action' => ['read'],
					'subject' => ['user', 'promoter', 'event', 'decor', 'settings-user']
				],
				[
					'action' => ['create'],
					'subject' => ['event', 'decor']
				],
				[
					'action' => ['update'],
					'subject' => ['event', 'decor']
				],
				[
					'action' => ['edit'],
					'subject' => ['event', 'decor']
				],
				[
					'action' => ['update_password'],
					'subject' => ['user']
				],
				[
					'action' => ['reject'],
					'subject' => []
				],
				[
					'action' => ['validate'],
					'subject' => []
				],
				[
					'action' => ['delete'],
					'subject' => ['event', 'decor']
				],
			],
			'promoter' => [
				[
					'action' => ['read'],
					'subject' => ['user', 'event', 'decor', 'payment', 'settings-user']
				],
				[
					'action' => ['create'],
					'subject' => ['event', 'decor', 'payment']
				],
				[
					'action' => ['edit'],
					'subject' => ['event', 'decor']
				],
				[
					'action' => ['update'],
					'subject' => ['event', 'decor']
				],
				[
					'action' => ['update_password'],
					'subject' => ['user']
				],
				[
					'action' => ['delete'],
					'subject' => ['event', 'decor']
				],
			],
		][$this->profile];
	}
}
