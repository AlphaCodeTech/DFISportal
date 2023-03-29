<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $user = User::create([
                'name'           => 'Admin',
                'photo'           => 'default.png',
                'status'           => 1,
                'email'          => 'admin@admin.com',
                'password'       => Hash::make('password'),
                'remember_token' => Str::random(60),
            ]);
            
            $user->assignRole('super admin');
        }
    }
}
