<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Studio;
use App\Models\StudioInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudioController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        $this->middleware('checkpermission');
    }

    public function inquiryList(Request $request){

        $filter = 0;
        $status = 0;
        $daterange = "";

    	$update = DB::table('studio_inquiries')->update(['is_seen' => 1]);

    	$query = StudioInquiry::orderBy('id','desc');

        if(isset($request->status) && $request->status != ''){
            $filter = 1;
            $status = $request->status;
            $query->where('status',$status);
        }

        if(isset($request->daterange) && $request->daterange != ''){
            $filter = 1;
            $daterange = $request->daterange;
            $date = explode('-',$request->daterange);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereDate('created_at','>=',$date1);
            $query->whereDate('created_at','<=',$date2);
        }

        $getInquiryList = $query->get();

    	return view('admin.studio-inquiry.inquiry_list',compact('getInquiryList','daterange','filter','status'));
    }

    public function changeInquiryStatus(Request $request){

    	$updateStatus = StudioInquiry::where('uuid',$request->id)->update(['status' => $request->status]);

        return $updateStatus ? 'true' : 'false';
    }

    //studio list
    public function studioList(Request $request){

        $filter = 0;
        $status = 0;
        $stateFilter = 0;
        $cityFilter = 0;
        $countryFilter = 0;

        $state = State::all();

        $city = City::all();

        $country = Country::all();

        $query = Studio::where('is_delete',0);

        if(isset($request->status) && $request->status != ''){
            $filter = 1;
            $status = $request->status;
            $s = $request->status == 2 ? 0 : 1;
            $query->where('is_active',$s);
        }

        if(isset($request->country_id) && $request->country_id != ''){
            $filter = 1;
            $countryFilter = $request->country_id;
            $query->where('country_id',$request->country_id);
        }

        if(isset($request->city_id) && $request->city_id != ''){
            $filter = 1;
            $cityFilter = $request->city_id;
            $query->where('city_id',$request->city_id);
        }

        if(isset($request->state_id) && $request->state_id != ''){
            $filter = 1;
            $stateFilter = $request->city_id;
            $query->where('state_id',$request->state_id);
        }
        
        $studio = $query->get();

        return view('admin.studio.studio',compact('studio','stateFilter','cityFilter','countryFilter','status','state','city','country','filter'));
    }

    //add studio
    public function addStudio(){

        return view('admin.studio.add_studio');
    }

    //save studio
    public function saveStudio(Request $request){

        $studio = new Studio;
        $studio->uuid = $this->generateUUID();
        $studio->name = $request->name;
        $studio->address = $request->address;
        $studio->country_id = $this->checkCountry($request->country);
        $studio->city_id = $this->checkCity($request->city);
        $studio->state_id = $this->checkState($request->state);
        $studio->save();

        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addStudio' : 'admin.studioList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Studio',
                'message' => 'Studio successfully added',
            ],
        ]);

    }

    //edit studio
    public function editStudio($uuid){

        $getStudio = Studio::where('uuid',$uuid)->with(['city','country','state'])->first();

        return view('admin.studio.edit_studio',compact('getStudio'));
    }

    //save edited studio
    public function saveEditedStudio(Request $request){

        $studio = Studio::findOrFail($request->id);
        $studio->name = $request->name;
        $studio->address = $request->address;
        $studio->country_id = $this->checkCountry($request->country);
        $studio->city_id = $this->checkCity($request->city);
        $studio->state_id = $this->checkState($request->state);
        $studio->save();

        return redirect(route('admin.studioList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Studio',
                'message' => 'Studio successfully updated',
            ],
        ]);

    }

    //save delete studio
    public function deleteStudio($uuid){

        $deleteStudent = Studio::where('uuid',$uuid)->update(['is_delete' => 1]);

        return redirect(route('admin.studioList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Studio',
                'message' => 'Studio successfully deleted',
            ],
        ]);
    }

    //change studio status
    public function changeStudioStatus(Request $request){

        $updateStatus = Studio::where('uuid',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }

}
