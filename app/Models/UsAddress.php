<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsAddress extends Model
{
    use HasFactory;
    protected $fillable =[
        "city",
        "address_line",
        "state",
        "zip_code"
    ];

      public function user(){
        return $this->belongsTo(User::class,'us_address_id');
    }
}