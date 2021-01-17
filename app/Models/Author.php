<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Author extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $dates=['DOB'];

    protected $fillable=[
        'name', 'DOB'
    ];

    public function setDOBAttribute($DOB){
        $this->attributes['DOB']=Carbon::parse($DOB);
    }
}
