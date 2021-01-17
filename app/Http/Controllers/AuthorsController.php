<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorsController extends Controller
{
    public function store(Request $request){
        $this->validateRequest();
        $author=DB::table('authors')
                ->insert([
                    'name'=>$request['name'],
                    'DOB'=>$request['DOB']
                ]);
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'DOB' => 'required',
        ]);
    }
}
