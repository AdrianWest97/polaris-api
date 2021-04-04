<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\PickUpLocation;
use App\Models\Status;
use App\Models\UsAddress;
use Database\Seeders\PickUpLocationSeeder;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function all(){
        return [
            "pick_ups" => PickUpLocation::all(),
            "package_status" =>Status::all(),
            "us_addresses" => UsAddress::all()
        ];
    }

    public function save_location(Request $request){
        $request->validate([
            'location' => ['required','string'],
            'id' => ['nullable','numeric']
        ]);
        $location = $request->id ? PickUpLocation::findOrFail($request->id) : New PickUpLocation;
        $location->location = $request->location;
        $location->save();
        return $location;
    }

    public function delete_location($id){
        return PickUpLocation::findOrFail($id)->delete();
    }
    public function save_us_address(Request $request){
        $request->validate([
            'address_line' => ['required','string'],
            'state' => ['required','string'],
            'city' => ['required','string'],
            'zip_code' => ['required','string'],
            'id' => ['nullable'],
            'is_default' => ["nullable"]
        ]);

        $address = $request->id ? UsAddress::find($request->id) : new UsAddress;
        $address->address_line = $request->address_line;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip_code = $request->zip_code;
        $address->is_default = $request->is_default ?? false;
        $address->save();

        //if set to default disable other addresses
        $addresses = UsAddress::where('id','!=',$address->id)->get();
        foreach($addresses as $a){
             $a->is_default = false;
             $a->save();
        }
        return $address;
    }

    public function delete_us_address($id){
        return UsAddress::findOrFail($id)->delete();
    }
}