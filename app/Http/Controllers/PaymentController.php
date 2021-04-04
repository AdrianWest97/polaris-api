<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'method' => ['required','string'],
            'amount' => ['required','numeric'],
            'user_id' => ['required','numeric'],
            'currency' => ['required','string'],
            'package_id' => ['required','numeric'],
        ]);
        $package = Package::find($request->package_id);
        $package->payment()->updateOrCreate(
            ['package_id' => $request->package_id],
        [
           'method' => $request->method,
           'amount' => $request->amount,
           'user_id' => $request->user_id,
           'currency' => $request->currency,
           'invoice_number' => $this->generate_invoice_number()
        ]);

        return Package::orderBy('created_at','desc')->get()->first()->loadMissing(['user','status','payment']);

    }

    public function all(){
        return response(['payments' =>Payment::with('package.user')->get()],200);
    }


    public function delete($id){
        return Payment::findOrFail($id)->delete();
    }

        public function generate_invoice_number(){
        //get last inseted
        $payment = Payment::orderBy("created_at",'desc')->get()->first();
        if(!is_null($payment)){
        return "INV".str_pad($payment->id+1,5,"0",STR_PAD_LEFT);
        }
       return "INV".str_pad(1,5,"0",STR_PAD_LEFT);

    }
}