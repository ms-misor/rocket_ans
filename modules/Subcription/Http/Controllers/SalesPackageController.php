<?php

namespace Modules\Subcription\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Role\Entities\Module;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Subcription\Entities\Package;
use Modules\Subcription\Entities\PackageDuration;
use Modules\Subcription\Http\Requests\PackageRequest;

class SalesPackageController extends Controller
{

    public function index()
    {
        return view('subcription::salespackages.__sales_packages',[
            'spackages'          => Package::with('modules')->where('package_type',2)->orderBy('id','desc')->get(),
            'modules'            => Module::where('type',2)->orderBy('id','desc')->get(),
        ]);
    }
    

    public function create()
    {

        return view('subcription::salespackages.create',[

            'modules'           => Module::orderBy('id','desc')->where('type',2)->get(),
            'packageDurations'  => PackageDuration::get(),
            'modules_id'        => [],

        ]);


    }


    public function store(PackageRequest $request)
    {
        $package = new Package();
        $package->fill($request->all());
        $package->offer_status = @$request->offer_status ?? 0;
        $package->status = @$request->status ?? 0;
        $package->package_type = 2;
        $package->duration = 1;
        
        if($package->save()){
            $modules_id = $request->module_id;
            $package->modules()->sync( $modules_id);
        }

        Toastr::success('Packages invoices added successfully :)','Success');
        return redirect()->route('salespackages.index');

    }

    public function show($id)
    {
        return view('subcription::show');
    }

    
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('subcription::salespackages.create',[
            'package'           => $package,
            'modules'           => Module::orderBy('id','desc')->where('type',2)->get(),
            'modules_id'        => $package->modules()->pluck('module_id')->toArray(),
            'packageDurations'  => PackageDuration::get()
        ]);
    }


    public function getPackageInfo(Request $request)
    {

        $package = Package::with('modules')->findOrFail($request->package_id);
       

        if($package->offer_status == 1){
            $ofstatus ='<span class="badge bg-success">Active</span>';
        }else{
            $ofstatus ='<span class="badge bg-danger">Inactive</span>';
        } 

        if($package->status == 1){
            $packStatus ='<span class="badge bg-success">Active</span>';
        }else{
            $packStatus ='<span class="badge bg-danger">Inactive</span>';
        } 

        $packModule = '';
        foreach(@$package->modules as $module){
            $packModule .= '<div class="col"><div class="p-2 border bg-light">'.$module->name.'</div></div>';
        }
       
        $info = '<div class="row ">
        
                    <div class="col-6">
                        <div class="p-2 border bg-light text-center">Package</div>
                        <div class="col-md-12">
                            <table class="table table-bordered table-sm text-center ">
                                <tr>
                                    <td width="50%" class="fw-bold">Title</td>
                                    <td >'.$package->title.'</td>
                                </tr>
                            
                                <tr>
                                    <td class="fw-bold">Price</td>
                                    <td >'.$package->price.'</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Duration</td>
                                    <td >'.($package->duration==1?"Monthly":"Yearly").'</td>
                                </tr>
                                
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>'.($packStatus).'</td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">Access Modules</td>
                                    <td>'.($packModule).'</td>
                                </tr>


                            </table>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="p-2 border bg-light text-center">Package Offer</div>
                        <table class="table table-bordered table-sm text-center">
                            <tr>
                                <td width="50%" class="fw-bold ">Title</td>
                                <td >'.@$package->offer.'</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Offer Amount</td>
                                <td>'.@$package->offer_price.'</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Offer Discount Amount</td>
                                <td>'.@$package->offer_discount .'</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Duration</td>
                                <td>'.@$package->offer_duration.' Days</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Offer Start Date</td>
                                <td>'.@$package->offer_start_date.'</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status</td>
                                <td>'.$ofstatus.'</td>
                            </tr>
                        </table>
                    </div>

                    <input type="hidden" id="package_price" value="'.$package->price.'">
                    <input type="hidden" id="package_duration" value="'.$package->duration.'">
                    <input type="hidden" id="offer_price" value="'.$package->offer_price.'">
                    <input type="hidden" id="offer_discount" value="'.$package->offer_discount.'">

                </div>';

                

        $modules= '';
            foreach($package->modules as $module){
                $modules .='<div class="col">
                <div class="p-2 border bg-light">'.$module->name.'</div>
             </div><br>';
            }

              
        $data = array(
            'packageinfo'       =>  $info,
            'modules'           =>  $modules,
            'package_price'     =>  $package->price,
            'package_duration'  =>  $package->duration
        );
        return json_encode($data);

        
    }

    public function update(Request $request, $id)
    {

        $package = Package::findOrFail($id);
        $package->fill($request->all());
        $package->offer_status = @$request->offer_status ?? 0;
        $package->status = @$request->status ?? 0;
        $package->package_type = 2;

        if($package->save()){
            $modules_id = $request->module_id;
            $package->modules()->sync( $modules_id);
        }

        Toastr::success('Package updated successfully :)','Success');
        return redirect()->route('salespackages.index');
    }


    public function destroy($id)
    {
        Package::findOrFail($id)->delete();
        Toastr::success('Package deleted successfully :)','Success');
        return response()->json(['success' => 'Data Deleted Successfully']);
    }
}
