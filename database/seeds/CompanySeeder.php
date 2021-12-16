<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();

        for ($i = 1; $i <= 10; $i++) {
            $data[] =
            [
                'name' => "テスト企業${i}",
                'company_code' => str_random(6),
                'email' => "company${i}@test.com",
                'password' => Hash::make('password')
            ];
        }
        DB::table('companies')->insert($data);
    }
}
