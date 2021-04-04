<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function address(){
        return $this->belongsTo(User::class,'user_id');
    }

    protected $fillable = [
        "street",
        "city",
        "parish",
        "user_id",
    ];
}