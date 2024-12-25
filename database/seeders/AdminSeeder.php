<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $existsing = User::where('role','admin')->first();
       if(!$existsing){
           User::create([
               'name' => 'Admin User',
               'email' => 'admin@email.com',
               'password' => Hash::make('123456'),
               'role'=>"admin"
           ]);
       }
    }
}
