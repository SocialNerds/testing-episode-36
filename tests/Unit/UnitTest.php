<?php

namespace Tests\Unit;

use App\Models\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAutoAssignUuids()
    {
        $book = new Book;
        $book->title = 'Book 1';
        $book->description = 'Awesome!';
        $book->isbn = '123';
        $book->save();

        $this->assertNotNull($book->id);
    }
}
