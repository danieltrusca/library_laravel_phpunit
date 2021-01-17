<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_author_can_be_created(){
        $this->withoutExceptionHandling();
        $this->post('/author', [
            'name'=>'Dan Trusca',
            'DOB'=>'1982-05-06'
        ]);

        $author=Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->DOB);
        $this->assertEquals('1982/06/05', $author->first()->DOB->format('Y/d/m'));
    }
}
