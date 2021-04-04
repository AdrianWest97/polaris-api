<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Notifications\packageUpdate;

class PackageController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'description' => ['required','string'],
            'store' => ['required','string'],
            'courier' => ['required','string'],
            'courier_number' => ['required','string'],
            'weight' => ['required','numeric'],
            'tracking_number' => ['required','string'],
            'notify' => ['nullable'],
            'status' => ['required','numeric'],
            'currency' => ['required','string'],
            'user_id' => ['required','numeric'],
            'due_payment' => ['required','numeric'],
            'shipment_date' => ['required','string'],
            'remarks' => ['nullable','string'],
        ]);

        //find user
        $package = is_null($request->id) ? New Package : Package::findOrfail($request->id);
        $package->user_id = $request->user_id;
        $package->description = $request->description;
        $package->store = $request->store;
        $package->courier = $request->courier;
        $package->courier_number = $request->courier_number;
        $package->weight = $request->weight;
        $package->tracking_number = $request->tracking_number;
        $package->status_id =  $request->status;
        $package->currency =  $request->currency;
        $package->due_payment = $request->due_payment;
        $package->shipment_date =  Carbon::parse($request->shipment_date)->format("y-m-d");
        is_null($request->id) ? $package->package_number = $this->generate_package_number(): ''; //generate package number
        $package->save(); //update or save
        $user = User::findOrfail($request->user_id);
        //if not drated, notify user
        if($request->notify){
            $this->sendPackageUpdateEmail($user,$package);
        }
          return $package
          ->loadMissing(['user','status','payment']);
    }

    public function sendPackageUpdateEmail($user, $package){
        //notify user

          $user->notify(new packageUpdate(
              [
                  'message'=> $package->status->email_template,
                  'status'=>$package->status->status,
                  'description' => $package->description,
                  'package_number' => $package->package_number,
                  'name' => $package->user->fname
                  ]));
    }


    public function all(){
        return response(['packages' => Package::all()->loadMissing(['user','status','payment'])],200);
    }

    public function generate_package_number(){
        //get last inseted
        $package = Package::orderBy("created_at",'desc')->get()->first();
        if(!is_null($package)){
        return str_pad($package->id +1 ,5,"0",STR_PAD_LEFT);
        }
       return str_pad(1,5,"0",STR_PAD_LEFT);

    }

    public function delete($id){
        return Package::find($id)->delete();
    }
        //generate unique reference number
   public function unique_id($l = 5) {
    return substr(md5(uniqid(mt_rand(), true)), 0, $l);
}

}