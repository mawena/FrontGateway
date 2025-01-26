<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{

		$adminUser = User::create(['name' => "admin", "email" => "admin@cofinacorp.com", "profile" => "admin", "password" => Hash::make("Coftg@20$*21ù!ad"), "activated" => true, "password_change_required" => false, "email_verified_at" => Carbon::now()]);
		$departmentList = Department::get()->pluck("id")->toArray();
		$adminUser->departments()->sync($departmentList);

		$plainTextToken = $adminUser->createToken("auth-token")->plainTextToken;
		DB::update("update personal_access_tokens set TOKEN = 'f34ac0f1237ee6854036c67e1e81fd1991375cdb2ca97b91cfc0839640f3e52f' where ID = 1");
		$plainTextToken = "1|o9CgVs9HDVzziZvfZ5i96If5aLlRfltjgTAiJ8K75764d4c1";
		echo "admin Token: " . $plainTextToken . "\n";

		$userList = [
			["name" => "Charles GAMLIGO", "email" => "charles.gamligo@cofinacorp.com", "profile" => "admin", "password" => "Coftg@20$*21ù!ad"],
			["name" => "AMADOU DIOP MAR", "email" => "amadou.diop@cofinacorp.com", "profile" => "admin", "password" => "Coftg@20$*21ù!ad"],
			["name" => "Claude KONOU", "email" => "claude.konou@cofinacorp.com", "profile" => "admin", "password" => "Coftg@20$*21ù!ad"],
			["name" => "Pedro Lonsosou KOZON", "email" => "lonsosou.kozon@cofinacorp.com", "profile" => "admin", "password" => "Coftg@20$*21ù!ad"],
			["name" => "Testeur", "email" => "testeur@cofinacorp.com", "profile" => "extractor", "password" => "P@sse123"],
		];

		foreach ($userList as $user) {
			$user = User::factory(1)->create(["name" => $user["name"], "profile" => $user["profile"], "password" => Hash::make($user["password"]), "password_change_required" => false, "activated" => true, "email" => $user["email"]])->first();
			$user->departments()->sync($departmentList);
		}
	}
}
