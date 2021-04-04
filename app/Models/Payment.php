<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'method',
        'amount',
        'invoice_number',
        'currency',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function package(){
        return $this->belongsTo(Package::class,'package_id');
    }

}