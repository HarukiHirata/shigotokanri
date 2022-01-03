<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Company;

class CompanyTest extends TestCase
{
    /**
     * @test
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    // public function データベースへの企業登録()
    // {
    //     $company = new Company;
    //     $company->company_code = 'unittcomp2';
    //     $company->name = 'ユニットテスト企業2';
    //     $company->email = 'unittestcomp2@test.com';
    //     $company->password = Hash::make('password');

    //     $companysave = $company->save();

    //     $this->assertTrue($companysave);
    // }

    /**
     * @test
     */
    // public function 企業登録画面表示()
    // {
    //     $response = $this->get('/company/register');

    //     $response->assertStatus(200)
    //              ->assertViewIs('company.register');
    // }

    public function 企業登録画面にて企業登録()
    {
        $data = [
            'company_code' => 'utcomp',
            'name' => 'UTテスト企業',
            'email' => 'utcomp@test.com',
            'password' => 'password',
        ];

        $response = $this->post('/company/store', $data);

        $response->assertRedirect('/company/home');
    }

    
}
