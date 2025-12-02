<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\user;
use Faker\Factory as Faker;

class userSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            user::create([
                'nama' => $faker->name,
                'nim' => $faker->numerify('22######'),
                'jurusan' => $faker->randomElement([
                    'Teknik Informatika',
                    'Teknik Elektro',
                    'Teknik Komputer',
                    'Teknik Mesin',
                ]),
                'email' => $faker->unique()->safeEmail,
                'no_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
            ]);
        }
    }
}
