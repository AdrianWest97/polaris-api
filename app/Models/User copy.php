<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,CascadesDeletes;

        protected $cascadeDeletes = ['address','pre_alerts','payments'];

        protected $fillable = [
        'fname',
        'lname',
        'phone',
        'id_type',
        'id_number',
        'email',
        'password',
        'us_address_id',
        'pickup_id'
    ];

    public function fullName(){
        return $this->fname.' '.$this->lname;
    }

    public function packages(){
        return $this->hasMany(Package::class,'user_id');
    }

    //pre alerts
      public function pre_alerts(){
        return $this->hasMany(PreAlert::class,'user_id');
    }

    //package payments
    public function payments(){
        return $this->hasMany(Payment::class,'user_id');
    }

    //user local address
          public function address(){
        return $this->hasOne(Address::class,'user_id');
    }

    //random us address
      public function us_address(){
        return $this->belongsTo(UsAddress::class,'us_address_id');
    }

        //preffered pickup location
      public function pick_up(){
        return $this->belongsTo(PickUpLocation::class,'pickup_id');
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
];
   public function sendEmailVerificationNotification($type = null)
    {
        $this->notify(new VerifyEmail($type));
    }

    //reset password
      public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }
}