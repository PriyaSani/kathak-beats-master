<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Auth;
use Redirect;
use Validator;
use App\Models\Admin;
use App\Models\City;
use App\Models\Workshop;
use App\Models\User;
use App\Models\Invoice;
use App\Models\StudioInquiry;
use App\Models\DashboardElement;
use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use Illuminate\Support\Facades\Input;

class AdminController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        //$this->middleware('checkpermission');
    }

    //Dashboard 
    public function index(){

        $faculties = Admin::where([['is_active',1],['is_delete',0],['id','!=',1]])->count();

        $onlineWorkshops = Workshop::where([['is_active',1],['is_delete',0],['engagement_type',2],['engagement_mode',2]])->count();

        $studioWorkshop = Workshop::where([['is_active',1],['is_delete',0],['engagement_type',2],['engagement_mode',1]])->count();

        $studioBatchs = Workshop::where([['is_active',1],['is_delete',0],['engagement_type',1],['engagement_mode',1]])->count();

        $onlineBatchs = Workshop::where([['is_active',1],['is_delete',0],['engagement_type',1],['engagement_mode',2]])->count();

        $student = User::where([['is_active',1],['is_delete',0]])->count();

        $getInquiry = StudioInquiry::select('purpose', \DB::raw('count(*) as total'))
                                   ->groupBy('purpose')
                                   ->get();
        
        $getDashBoardElement = DashboardElement::where('admin_id',Auth::guard('admin')->user()->id)->pluck('element_id')->toArray();

        return view('admin.dashboard.dashboard',compact('faculties','onlineWorkshops','studioWorkshop','studioBatchs','onlineBatchs', 'student','getDashBoardElement'));
    }

    public function studentReport(){
        
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $active = array();
        $inActive = array();

        for($i = 1;$i <= 12; $i++){
            $activeUser = User::where('is_active',1)->whereMonth('created_at',$i)->whereYear('created_at',date('Y'))->where('is_delete',0)->count();
            $inActiveUser = User::where('is_active',0)->whereMonth('created_at',$i)->whereYear('created_at',date('Y'))->where('is_delete',0)->count();
            $active[] = $activeUser;
            $inActive[] = $inActiveUser;
        }

        $data['months'] = $months;
        $data['active'] = $active;
        $data['in_active'] = $inActive;

        return $data;
    }

    public function invoiceReport(){

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];   
        $bAmount = array();
        $rAmount = array();

         for($i = 1;$i <= 12; $i++){

            $totalBilled = Invoice::where('is_active',1)->where('is_delete',0)->whereMonth('created_at',$i)->whereYear('created_at',date('Y'))->sum('amount');
            $recivedAmount = Invoice::where('is_active',1)->where('is_delete',0)->where('status','PAID')->whereMonth('created_at',$i)->whereYear('created_at',date('Y'))->sum('amount');
            
            $bAmount[] = $totalBilled;
            $rAmount[] = $recivedAmount;
        }

        $data['months'] = $months;
        $data['bamount'] = $bAmount;
        $data['ramount'] = $rAmount;

        return $data;
    }

    public function getCardCount(){

        $collaborations = 0;
        $regularBatch = 0;
        $upcoming = 0;

        $purpose = array('Collaborations','Regular Batch Enquiry','Upcoming Workshop Enquiry');

        $getInquiry = StudioInquiry::select('purpose', \DB::raw('count(*) as total'))
                                   ->groupBy('purpose')
                                   ->get();

        if(!is_null($getInquiry)){
            foreach($getInquiry as $ik => $iv){
                if($iv->purpose == 'Collaborations'){
                    $collaborations = $iv->total;
                }
                if($iv->purpose == 'Regular Batch Enquiry'){
                    $regularBatch = $iv->total;
                }
                if($iv->purpose == 'Upcoming Workshop Enquiry'){
                    $upcoming = $iv->total;
                }
            }
        }                                   

        $count = array($collaborations,$regularBatch,$upcoming);

        return $count;
    }

    // Change Password
    public function changeAdminPassword(){
        return view('admin.dashboard.change_password');
    }

    // Update Password
    public function updateAdminPassword(Request $request){

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $admin = Admin::where('id', '=', Auth::guard('admin')->user()->id)->first();

        if(Hash::check($request->old_password, $admin->password)){

            $user = Admin::findOrFail(Auth::guard('admin')->user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect(route('admin.dashboard'))->with('messages', [
		        [
		            'type' => 'success',
		            'title' => 'User',
		            'message' => 'Password successfully changed',
		        ],
		    ]);

        } else {
          	
          	return redirect()->back()->with('messages', [
		        [
		            'type' => 'success',
		            'title' => 'User',
		            'message' => 'Password not matched',
		        ],
		    ]);
        }
    }
   	
   	//Profile
   	public function adminProfile(Request $request){

   		return view('admin.dashboard.admin_profile');
   	}

    public function updateProfile(Request $request){

        $user = Admin::findOrFail($request->id);
        $user->name = $request->name;
        if(isset($request->profile)){
            $filename = $this->uploadBucket($request->profile,'profile');
            $user->profile_image = $filename;
        }
        $user->address = $request->address;
        $user->city_id = $request->city_id ? $request->city_id : $this->checkCity($request->city);
        $user->state_id = $request->state_id ? $request->state_id : $this->checkState($request->state);
        $user->dob = '1994-12-05';
        $user->blood_group = $request->blood_group;
        $user->mobile = $request->mobile;
        $user->name = $request->name;
        $user->save();

        return redirect(route('admin.dashboard'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Profile',
                'message' => 'Profile successfully updated',
            ],
        ]);


    }

    public function uploadProfilePic(Request $request){
        return view('admin.dashboard.img_check');
    }
    
    public function uploadProfile(Request $request){

        if(isset($request->profile)){
            $filename = $this->uploadBucket($request->profile,'profile');
        }

        exit;
    }   
}