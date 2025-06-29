<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Shop\Database\Seeders\ShopDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if ($this->command->confirm('Apakah Anda ingin me-refresh database migrasi? Ini akan menghapus semua data.')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database di-refresh. Semua data lama telah dihapus.');
        }

        if($this->command->confirm('Apakah Anda ingin membuat akun user dummy?')) {
        $user = User::factory()->create([
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ]);
        $this->command->info("User dummy berhasil dibuat: ");
        $this->command->warn("Email: {$user->email}");
        $this->command->warn("Password: password");
    }

        if($this->command->confirm('Apakah Anda ingin menambahkan data produk contoh?')) {
        $this->call([ShopDatabaseSeeder::class]);
        }
    }
}
