<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function all(){
        return Status::select('id','status')->get();
    }

    public function store(Request $request){
        $request->validate([
         'status' => ['required' => 'string'],
         'email_template' => ['required' => 'string'],
         'id' => ['nullable','numeric']
        ]);

        $status = $request->id ? Status::findOrFail($request->id) : new Status;
        $status->status = $request->status;
        $status->email_template = $request->email_template;
        $status->save();
        return $status;
    }
}