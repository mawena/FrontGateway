<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
		$adminUser = User::create(['name' => "admin", "email" => "admin@pecorator.com", "profile" => "admin", "password" => Hash::make("azerty"), "activated" => true]);

		// $plainTextToken = $adminUser->createToken("auth-token")->plainTextToken;
		// DB::update("update personal_access_tokens set TOKEN = 'f34ac0f1237ee6854036c67e1e81fd1991375cdb2ca97b91cfc0839640f3e52f' where ID = 1");
		// $plainTextToken = "1|3EHtZpCFL35Mn1tff8F1JxPhNTfCsxNveKXdC652a8400aed";
		// echo "admin Token: " . $plainTextToken . "\n";
    }
}
