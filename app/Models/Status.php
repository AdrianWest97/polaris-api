<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable =["status","color","email_template"];

    public function packgae(){
        return $this->hasMany(Package::class,'status_id');
    }
}