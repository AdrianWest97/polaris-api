<?php

namespace App\Http\Controllers;

use App\Models\PreAlert;
use Illuminate\Http\Request;
use App\Models\User;

class PreAlertController extends Controller
{
    public function store(Request $request){
        $request->validate([
        'description' => ['required'],
        'store' => ['required','string'],
        'weight'=> ['required','numeric'],
        'tracking_number' => ['required','string'],
        'instructions' => ['nullable','string'],
        'approved' => ['nullable'],
        'mode' => ['required','string'],
        'id' => ['nullable'],
        ]);

        $user = User::find(auth()->id());
        $user->pre_alerts = $request->mode == 'add' ? New PreAlert : PreAlert::findOrfail($request->id);
         $user->pre_alerts->description = $request->description;
         $user->pre_alerts->store = $request->store;
         $user->pre_alerts->weight = $request->weight;
         $user->pre_alerts->instructions = $request->instructions;
         $user->pre_alerts->approved = $request->approved;
         $user->pre_alerts->user_id = $user->id;
         $user->pre_alerts->tracking_number = $request->tracking_number;
          $user->pre_alerts->save();
         return $user->pre_alerts;
    }

    public function all(){
        return response(['pre_alerts' => PreAlert::orderBy('updated_at','asc')->with(['user'])->get()],200);
    }

    public function update_status($id){
        $pre_alert = PreAlert::findOrFail($id);
        $pre_alert->approved = !$pre_alert->approved;
        $pre_alert->save();
        return $pre_alert->loadMissing('user');
    }

    public function delete($id){
        return PreAlert::find($id)->delete();
    }
}