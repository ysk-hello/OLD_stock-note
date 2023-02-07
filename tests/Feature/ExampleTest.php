<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testControllerTest(){
        $this->get('/')->assertStatus(302);
        $this->get('/login')->assertOK();
    }

    public function testModelTest(){
        $data = [
            'id' => 1,
        ];

        $this->assertDatabaseHas('articles', $data);

        $data2 = [
            'id' => 120,
            'stock_name' => 'KDDI',
            'text' => 'hogehoge',
            'user_id' => 1,
            //'created_at' => date('now'),
            //'updated_at' => date('now'),
        ];

        // create
        $article = new Article();
        $article->fill($data2)->save();
        $this->assertDatabaseHas('articles', $data2);

        // update
        $article->stock_name = 'NTT';
        $article->save();
        $this->assertDatabaseMissing('articles', $data2);

        // delete
        $article->delete();
        $this->assertDatabaseMissing('articles', $data2);
    }
}
