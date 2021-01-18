<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library(){
        //$this->withoutExceptionHandling();
        $response=$this->post('/books',$this->data());

        $book=Book::first();

        //$response->assertOK();
        $this->assertCount(1, Book::all());

        $response->assertRedirect('/books/'.$book->id);
    }

    /** @test */
    public function a_title_is_required(){
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_book_can_be_updated(){
        //$this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);

        $response->assertRedirect('/books/'.$book->id);
    }

    /** @test */
    public function a_book_can_be_deleted(){
        $this->withoutExceptionHandling();
        $this->post('/books',$this->data());

        $book=Book::first();
        //$this->assertCount(1, Book::all());

        $response=$this->delete('/books/'.$book->id);

        //$this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added(){
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor',
        ];
    }
}
