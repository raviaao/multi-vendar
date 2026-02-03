<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Agar admin pehle se hai to update kar de, nahi hai to create
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // check by email
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin' // agar role column hai, nahi to hata do
            ]
        );

        $this->command->info('Admin user added/updated successfully!');
    }
}
