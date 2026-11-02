<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::firstOrCreate(
            ['email' => 'admin@desa.local'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Create Kepala Desa
        User::firstOrCreate(
            ['email' => 'kades@desa.local'],
            [
                'name' => 'Kepala Desa Kalinaun',
                'username' => 'kades',
                'password' => Hash::make('kades123'),
                'role' => 'kepala_desa',
                'status' => 'active',
            ]
        );

        // Create Default Masyarakat User
        $masyarakatUser = User::where('email', 'abraham@desa.local')
            ->orWhere('nik', '8171031503040005')
            ->first();

        if (!$masyarakatUser) {
            User::create([
                'name' => 'Abraham Petra Titihalawa',
                'email' => 'abraham@desa.local',
                'username' => 'abraham',
                'nik' => '8171031503040005',
                'password' => Hash::make('user123'),
                'role' => 'masyarakat',
                'status' => 'active',
            ]);
        }

        $this->command->info('Admin, Kepala Desa, dan Masyarakat berhasil dibuat!');
        $this->command->line('');
        $this->command->line('===== DATA LOGIN =====');
        $this->command->line('');
        $this->command->line('ADMIN:');
        $this->command->line('  Username: admin');
        $this->command->line('  Password: admin123');
        $this->command->line('');
        $this->command->line('KEPALA DESA:');
        $this->command->line('  Username: kades');
        $this->command->line('  Password: kades123');
        $this->command->line('');
        $this->command->line('MASYARAKAT:');
        $this->command->line('  Username: abraham');
        $this->command->line('  Password: user123');
        $this->command->line('');
    }
}
