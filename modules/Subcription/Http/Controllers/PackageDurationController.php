<?php

namespace Modules\Subcription\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subcription\Entities\PackageDuration;
use Brian2694\Toastr\Facades\Toastr;

class PackageDurationController extends Controller
{

    public function index()
    {

        return view('subcription::package-duration.index',[
            'packageDurations' => PackageDuration::get()
        ]);
    }

    public function create()
    {
        return view('subcription::create');
    }

    public function store(Request $request)
    {
        $packageDuration = new PackageDuration();
        $packageDuration->fill($request->all());
        
        if($request->unit == 1){
            $packageDuration->title = 'Monthly';
            $packageDuration->unit = $request->unit ;
        }
        elseif($request->unit == 3){
            $packageDuration->title = 'Quarterly';
            $packageDuration->unit = $request->unit ;
        }
        elseif($request->unit == 6){
            $packageDuration->title = 'Biannual';
            $packageDuration->unit = $request->unit ;
        }
        elseif($request->unit == 12){
            $packageDuration->title = 'Yearly';
            $packageDuration->unit = $request->unit ;
        }
        $packageDuration->save();
        Toastr::success('Package Duration created successfully :)','Success');
        return redirect()->route('package-durations.index');


    }

    public function show($id)
    {
        return view('subcription::show');
    }


    public function edit($id)
    {
        return view('subcription::edit');
    }

    public function update(Request $request, $id)
    {
        // return $request->all();

        $packageDuration = PackageDuration::findOrFail($id);

        $packageDuration->status = $request->status ? 1 : 0;
         
        $packageDuration->fill($request->all());
        

        // if($request->unit == 1){
        //     $packageDuration->title = 'Monthly';
        //     $packageDuration->unit = $request->unit ;
        // }
        // elseif($request->unit == 3){
        //     $packageDuration->title = 'Quarterly';
        //     $packageDuration->unit = $request->unit ;
        // }
        // elseif($request->unit == 6){
        //     $packageDuration->title = 'Biannual';
        //     $packageDuration->unit = $request->unit ;
        // }
        // elseif($request->unit == 12){
        //     $packageDuration->title = 'Yearly';
        //     $packageDuration->unit = $request->unit ;
        // }
        $packageDuration->save();

        Toastr::success('Package Duration updated successfully :)','Success');
        return redirect()->route('package-durations.index');
    }

    
}
