<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// HOW TO CALL THIS SEEDER
// php artisan db:seed --class=UserDummySeeder

class UserDummySeeder extends Seeder
{
  /**
   * Run the database seeders.
   */
  public function run(): void
  {
    // User Mahasiswa (Role: user)
    User::create([
      'name'              => 'Azka Ryan Pradipta',
      'nim'               => '202210370311001',
      'major'             => 'Informatika',
      'email'             => 'admin1@webmail.umm.ac.id',
      'whatsapp_no'       => '081234567890',
      'email_verified_at' => now(),
      'role'              => 'admin',
      'password'          => Hash::make('ADMIN123'),
    ]);

    // Admin Sistem (Role: admin)
    User::create([
      'name'              => 'Administrator Sistem',
      'nim'               => '202210370311999',
      'major'             => 'Informatika',
      'email'             => 'admin2@webmail.umm.ac.id',
      'whatsapp_no'       => '089876543210',
      'email_verified_at' => now(),
      'role'              => 'admin',
      'password'          => Hash::make('ADMIN123'),
    ]);
  }
};
