<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all(){
        return response (['users'=>User::where('is_admin',false)
        ->with([
            'packages',
            'pre_alerts',
            'payments',
            'address',
            'us_address',
            'pick_up'
            ])
        ->get()],200);
    }

    public function get_packages_payments_prealerts(){
        return User::select('id')->where('id',auth()->id())->with(['pre_alerts','payments','packages'=> function($q){
             $q->with(array('status','payment'));
        }])->get()->first();
    }

    public function delete($id){
        return User::findOrfail($id)->delete();
    }

}