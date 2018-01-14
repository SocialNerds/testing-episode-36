<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanCreateABook()
    {
        // Create a user.
        $user = factory(User::class)->create();

        // Create a book.
        $response = $this->actingAs($user, 'api')->json(
          'POST',
          '/api/books',
          [
            'title'       => 'First book',
            'description' => 'Awesome',
            'isbn'        => '12a32',
          ]
        );

        $bookId = json_decode($response->content())->id;

        $response->assertStatus(201);

        // Get books.
        $response = $this->actingAs($user, 'api')
          ->get('/api/books');

        $response->assertStatus(200)
          ->assertJsonFragment(
            [
              'title'       => 'First book',
              'description' => 'Awesome',
              'isbn'        => '12a32',
            ]
          );

        // Delete a book.
        $response = $this->actingAs($user, 'api')
          ->delete('/api/books/'.$bookId);

        $response->assertStatus(202);

        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2, 'api')->json(
          'GET',
          '/api/books'
        );

        $response->assertStatus(200)
          ->assertJsonFragment(['data' => []]);


        // User doesn't has favorites.
        $response = $this->actingAs($user2, 'api')->json(
          'GET',
          '/api/favorites'
        );

        $response->assertStatus(200)
          ->assertJsonFragment(
            [
              'data' => [],
            ]
          );

        // Create two books.
        $book1 = factory(Book::class)->create();
        $book2 = factory(Book::class)->create();

        // Add to favorites.
        $response = $this->actingAs($user2, 'api')->json(
          'POST',
          '/api/favorites',
          ['id' => $book1->id]
        );

        $response->assertStatus(201)
          ->assertSeeText('Added');

        // Add to favorites.
        $response = $this->actingAs($user2, 'api')->json(
          'POST',
          '/api/favorites',
          ['id' => $book2->id]
        );

        $response->assertStatus(201)
          ->assertSeeText('Added');

        // User has favorites.
        $response = $this->actingAs($user2, 'api')->json(
          'GET',
          '/api/favorites'
        );

        $data = [
          [
            'description' => $book1->description,
            'id'          => $book1->id,
            'isbn'        => $book1->isbn,
            'title'       => $book1->title,
          ],
          [
            'description' => $book2->description,
            'id'          => $book2->id,
            'isbn'        => $book2->isbn,
            'title'       => $book2->title,
          ],
        ];
        $response->assertStatus(200)
          ->assertJson(
            [
              'data' => $data,
            ],
            false
          );

        // User can see User2 has favorites.
        $response = $this->actingAs($user, 'api')->json(
          'GET',
          '/api/favorites/'.$user2->id
        );

        $response->assertStatus(200)
          ->assertJson($data, false)
          ->assertJsonCount(2);

        // Delete from favorites.
        $response = $this->actingAs($user, 'api')->json(
          'DELETE',
          '/api/favorites/' . $book1->id
        );

        $response->assertStatus(202)
            ->assertSeeText('Deleted');
    }
}
