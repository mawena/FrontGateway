<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Promoter;
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
		
		foreach([1, 2, 3] as $i){
			User::create(['name' => "Supervisor-0$i", "email" => "supervisor0$i@pecorator.com", "profile" => "supervisor", "password" => Hash::make("azerty"), "activated" => true]);
			User::create(['name' => "Promoter-0$i", "email" => "promoter0$i@pecorator.com", "profile" => "promoter", "password" => Hash::make("azerty"), "activated" => true]);
		}
		
		$plainTextToken = $adminUser->createToken("auth-token")->plainTextToken;
		DB::update("update personal_access_tokens set TOKEN = '2c496c4d9f53a79203d3c831e639f90d5c66a02c490a11505e07d185329db631' where ID = 1");
		$plainTextToken = "1|3EHtZpCFL35Mn1tff8F1JxPhNTfCsxNveKXdC652a8400aed";
		echo "admin Token: " . $plainTextToken . "\n";
    }
}
