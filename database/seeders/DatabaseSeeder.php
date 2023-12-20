<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '01000000000',
            'password' => bcrypt('12345678'),
            'is_admin' => true,
        ]);

        $this->call(ProductsTableSeeder::class);
    }
}
