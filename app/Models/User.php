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


	public function toArray()
	{
		$data = parent::toArray();
		$data["created_at_fr"] = Carbon::parse($data["created_at"])->format("d/m/yy H:i:s");
		$data["updated_at_fr"] = Carbon::parse($data["updated_at"])->format("d/m/yy H:i:s");
		$data["activated"] = (bool) $data["activated"];
		return $data;
	}

	public function getProfileFrAttribute()
	{
		return [
			'admin' => 'Administrateur',
			'supervisor' => 'Superviseur',
			'promoter' => 'Promoteur',
		][$this->profile];
	}

	public function promoter(): HasOne{
		return $this->hasOne(Promoter::class, "user_id", "id");
	}
	public function events(): HasMany{
		return $this->hasMany(Event::class, 'promoter_id', 'id');
	}
	public function decors(): HasMany{
		return $this->hasMany(Decor::class, 'promoter_id', 'id');
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
					'subject' => ['user', 'promoter', 'event', 'decor']
				],
				[
					'action' => ['create'],
					'subject' => ['user','promoter', 'event', 'decor']
				],
				[
					'action' => ['edit'],
					'subject' => ['promoter', 'event', 'decor']
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
			'promoter' => [
				[
					'action' => ['read'],
					'subject' => ['user', 'event', 'decor']
				],
				[
					'action' => ['create'],
					'subject' => ['event', 'decor']
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
