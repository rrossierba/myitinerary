<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = '12345678';
        $users = ['Admin', 'Mario Rossi', 'Gino Verdi', 'Pietro Bianchi', 'Giovanni Storti', 'Giacomo Poretti', 'Aldo Baglio'];

        foreach($users as $user){
            User::factory()->create([
                'name' => $user,
                'email' => strtolower(explode(' ', $user)[0].'@example.it'),
                'password' => Hash::make($password),
                'role' => $user === 'Admin'?'admin':'registered_user'
            ]);
        }
    }
}
