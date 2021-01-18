<?php

namespace Tests\Unit;

use App\Models\Book;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;


class BookTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_author_id_is_recorded(){
        Book::create([
            'title'=>'Another name',
            'author_id'=>1
        ]);
        // $book=DB::table('books')
        //     ->insert([
        //         'name'=>'Another name',
        //          'author_id'=>1
        //     ]);

        $this->assertCount(1, Book::all());
    }
}
