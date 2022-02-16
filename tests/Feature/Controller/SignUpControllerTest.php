<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPSTORM_META\override;

/**
 * @see App\Http\Controllersf\SignUpController
 */
class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test index*/
    function ユーザー登録画面表示()
    {
        $this->get('signup')
            ->assertOk();
    }

    // private function validData($overrides = [])
    // {
    //     return array_merge(
    //         [
    //             'name' => '太郎',
    //             'email' => 'test@gmail.com',
    //             'password' => 'test12345',
    //         ],
    //         $overrides
    //     );
    // }

    /** @test store */
    function ユーザー登録させる()
    {
        // データ検証
        // DBに保存
        // マイページにリダイレクト

        // $validData = [
        //     'name' => '太郎',
        //     'email' => 'test@gmail.com',
        //     'password' => 'test12345',
        // ];
        
        // $validData = $this->validData();
        // $validData = User::factory()->valid()->raw();
        $validData = User::factory()->validData();
        $this->post('signup', $validData)
            ->assertOk();

        unset($validData['password']);
        $this->assertDatabaseHas('users', $validData);

        // パスワードの検証
        $user = User::firstWhere($validData);
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('test12345', $user->password));
    }
}
