<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use Illuminate\Support\Facades\DB;

class EmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,30) as $index) {
            DB::table('emails')->insert([
                'to' => $faker->email,
                'subject' => $faker->text(56),
                'content' => $faker->text(400),
                'sended_date' => $faker->dateTime(),
                'user_id' => null
            ]);
        }
    }
}
