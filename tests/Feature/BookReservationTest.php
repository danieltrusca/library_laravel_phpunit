<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library(){
        //$this->withoutExceptionHandling();
        $response=$this->post('/books',[
            'title'=>'Follow your dreams',
            'author'=>'Naomi Mae'
        ]);

        $book=Book::first();

        //$response->assertOK();
        $this->assertCount(1, Book::all());

        $response->assertRedirect('/books/'.$book->id);
    }

    /** @test */
    public function a_title_is_required(){
        // $this->withoutExceptionHandling();
        $response=$this->post('/books',[
            'title'=>'',
            'author'=>'Naomi Mae'
        ]);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_book_can_be_updated(){
        //$this->withoutExceptionHandling();
        $this->post('/books',[
            'title'=>'My bloody Valentine',
            'author'=>'Nao Xi'
        ]);

        $book=Book::first();

        $response=$this->patch('/books/'.$book->id,[
            'title'=>'Some stories',
            'author'=>'Xi Chan'
        ]);

        $this->assertEquals('Some stories', Book::first()->title);
        $this->assertEquals('Xi Chan', Book::first()->author);

        $response->assertRedirect('/books/'.$book->id);
    }

    /** @test */
    public function a_book_can_be_deleted(){
        $this->withoutExceptionHandling();
        $this->post('/books',[
            'title'=>'My bloody Valentine',
            'author'=>'Nao Xi'
        ]);

        $book=Book::first();
        $this->assertCount(1, Book::all());

        $response=$this->delete('/books/'.$book->id);

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
