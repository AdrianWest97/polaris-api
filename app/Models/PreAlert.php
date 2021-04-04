<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'store',
        'weight',
        'tracking_number'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
