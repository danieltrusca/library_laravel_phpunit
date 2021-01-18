<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{


    public function store()
    {
        $book = Book::create($this->validateRequest());

        return redirect('/books/'.$book->id);
    }

    // public function update(Book $book)
    // {
    //     $book->update($this->validateRequest());

    //     return redirect('/books/'.$book->id);
    // }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author_id' => 'required',
        ]);
    }
    // public function store(Request $request){
    //     $this->validateRequest();
    //     $affected=DB::table('books')
    //         ->insert([
    //             'title'=>$request->title,
    //             'author_id'=>$request->author_id
    //         ]);

    //     $book=DB::table('books')
    //             ->orderBy('id', 'desc')
    //             ->first();

    //     return redirect('/books/'.$book->id);
    // }

    public function update(Request $request, $id){
        $this->validateRequest();
        $affected = DB::table('books')
              ->where('id', $id)
              ->update(['title'=>$request['title'], 'author_id'=>$request['author_id']]);

        return redirect('/books/'.$id);

    }

    // public function destroy($id){
    //     $affected=DB::table('books')
    //                 ->where('id', '=', $id)
    //                 ->delete();

    //     return redirect('/books');
    // }

    // protected function validateRequest()
    // {
    //     return request()->validate([
    //         'title' => 'required',
    //         'author_id' => 'required',
    //     ]);
    // }
}
