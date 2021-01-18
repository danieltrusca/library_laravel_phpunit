<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out(){
        //$book->checkout($user);
        //$user->checkout($book;
        // $book=factory(Book::class)->create();
        // $user=factory(User::class)->create();

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test */
    public function a_book_can_be_returned(){
        $user=User::factory()->create();
        $book=Book::factory()->create();

        $book->checkout($user);

        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);

    }

    /** @test */
    public function if_not_checked_out_exception_is_thrown()
    {
        $this->expectException(\Exception::class);

        $user=User::factory()->create();
        $book=Book::factory()->create();

        $book->checkin($user);
    }

    /** @test */
    public function a_user_can_check_out_a_book_twice()
    {
        $user=User::factory()->create();
        $book=Book::factory()->create();

        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_in_at);
    }
}
