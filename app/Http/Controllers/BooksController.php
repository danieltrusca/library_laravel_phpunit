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
    }

    public function edit(Request $request, $id){
        $this->validateRequest();
        $affected = DB::table('books')
              ->where('id', $id)
              ->update(['title'=>$request['title'], 'author'=>$request['author']]);

    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
    }
}
