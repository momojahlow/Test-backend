<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Societe::factory(5)->create();

        \App\Models\User::factory()->create([
            'prenom' => 'Admin',
            'nom' => 'admin',
            'type' => 'admin',
            'email' => 'admin001@yopmail.com',
        ]);
    }
}
