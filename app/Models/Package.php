<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'store',
        'courier',
        'package_number',
        'courier_number',
        'weight',
        'tracking_number',
        'status',
        'due_payment',
        'shipment_date',
        'currency',
        'pieces',
        'remarks',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function status(){
        return $this->belongsTo(Status::class,'status_id');
    }
    public function payment(){
        return $this->hasOne(Payment::class,'package_id');
    }
}