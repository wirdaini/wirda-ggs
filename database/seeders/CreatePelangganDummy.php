<?php
namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePelangganDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Buat array kosong untuk menampung data
        $pelanggan = [];
        for ($i = 0; $i < 50; $i++) {
            $pelanggan[] = [
                'first_name' => $faker->firstName(),
                'last_name'  => $faker->lastName(),
                'birthday'   => $faker->date(),
                'gender'     => $faker->randomElement(['Male', 'Female']),
                'email'      => $faker->unique()->safeEmail(), // unique() agar tidak ada email yang sama
                'phone'      => $faker->phoneNumber(),
                'created_at' => now(), // Disini manual karena tidak pakai Model
                'updated_at' => now(), // Disini manual karena tidak pakai Model
            ];
        }

        DB::table('pelanggan')->insert($pelanggan);
    }
}
