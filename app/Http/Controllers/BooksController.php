<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    public function store(Request $request){
        $this->validateRequest();
        $affected=DB::table('books')
            ->insert([
                'title'=>$request->title,
                'author'=>$request->author
            ]);

        $book=DB::table('books')
                ->orderBy('id', 'desc')
                ->first();

        return redirect('/books/'.$book->id);
    }

    public function edit(Request $request, $id){
        $this->validateRequest();
        $affected = DB::table('books')
              ->where('id', $id)
              ->update(['title'=>$request['title'], 'author'=>$request['author']]);

        return redirect('/books/'.$id);

    }

    public function destroy($id){
        $affected=DB::table('books')
                    ->where('id', '=', $id)
                    ->delete();

        return redirect('/books');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
    }
}
