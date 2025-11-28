<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker; //

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BUAT FAKER DULU
        $faker = Faker::create();

        User::create([
            'name'     => 'Admin',
            'email'    => 'gatot@pcr.ac.id',
            'password' => Hash::make('gatotkaca'),
        ]);

        // Create 50 dummy users dengan nama random
        for ($i = 0; $i < 50; $i++) {
            User::create([
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => Hash::make('password123'),
            ]);
        }

        echo "Berhasil membuat 51 users! \n";
        echo "✅ 1 Admin \n";
        echo "✅ 50 User Dummy dengan nama random \n";
    }
}
