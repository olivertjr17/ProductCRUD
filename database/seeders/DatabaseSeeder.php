<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::query()->delete();
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('@admin123'),
        ]);


        $this->call(ProductSeeder::class);
    }
}
