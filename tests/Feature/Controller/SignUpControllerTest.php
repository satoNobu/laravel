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
            ->assertRedirect('mypage/blogs');

        unset($validData['password']);
        $this->assertDatabaseHas('users', $validData);

        // パスワードの検証
        $user = User::firstWhere($validData);
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('test12345', $user->password));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    function 不正なデータ()
    {
        $url = 'signup';

        // $this->post($url, [])
        //     ->assertRedirect();

        // dumpSession
        $this->post($url, ['name' => ''])->assertSessionHasErrors(['name' => '名前は必ず指定してください。']);
        $this->post($url, ['name' => str_repeat('a', 21)])->assertSessionHasErrors(['name' => '名前は、20文字以下で指定してください。']);
        $this->post($url, ['name' => str_repeat('a', 20)])->assertSessionDoesntHaveErrors('name');

        $this->post($url, ['email' => ''])->assertSessionHasErrors(['email' => 'メールアドレスは必ず指定してください。']);
        $this->post($url, ['email' => 'aaa@bbb@ccc'])->assertSessionHasErrors(['email' => 'メールアドレスには、有効なメールアドレスを指定してください。']);
        $this->post($url, ['email' => 'ああああ@ccc'])->assertSessionHasErrors(['email' => 'メールアドレスには、有効なメールアドレスを指定してください。']);

        User::factory()->create(['email' => 'test@gmail.com']);
        $this->post($url, ['email' => 'test@gmail.com'])->assertSessionHasErrors(['email' => 'メールアドレスの値は既に存在しています。']);

        $this->post($url, ['password' => ''])->assertSessionHasErrors(['password' => 'パスワードは必ず指定してください。']);
        $this->post($url, ['password' => str_repeat('a', 7)])->assertSessionHasErrors(['password' => 'パスワードは、8文字以上で指定してください。']);
        $this->post($url, ['password' => str_repeat('a', 8)])->assertSessionDoesntHaveErrors('password');
    }
}
