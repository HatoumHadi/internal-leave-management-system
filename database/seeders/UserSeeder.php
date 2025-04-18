<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'department_id' => Department::inrandomOrder()->first()->id,
            'role_id' => Role::whereName('Admin')->first()->id,
        ]);

        $employee = User::factory()->create([
            'name' => 'Hadi Hatoum',
            'email' => 'hadiEmployee@mail.com',
            'password' => Hash::make('password'),
            'department_id' => Department::inrandomOrder()->first()->id,
            'role_id' => Role::whereName('Employee')->first()->id,
        ]);

    }
}
