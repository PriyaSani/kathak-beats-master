<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailDelivery;

class EmailController extends Controller
{
    public function bouncesProduction(Request $request){

        $content = $request->getContent();
        $data = json_decode($content,true);
        $message = json_decode($data['Message'],true);
        $email = $message['mail']['destination'][0];

        $emailCount = $this->getEmailCount($email);

        if($emailCount == 3){

            $user = User::where('email',$email)->update(['is_blocked' => 1]);
            
        } else {

            $addEmail = $this->addEmailEntry('BOUNCE',$email);
        }

        return 'true';
    }

    public function complaintsProduction(Request $request){
        
        $content = $request->getContent();
        $data = json_decode($content,true);
        $message = json_decode($data['Message'],true);
        $email = $message['mail']['destination'][0];

        $emailCount = $this->getEmailCount($email);

        if($emailCount == 3){

            $user = User::where('email',$email)->update(['is_blocked' => 1]);
            
        } else {

            $addEmail = $this->addEmailEntry('COMPLAINT',$email);
        }

        return 'true';
    }

    public function deliveriesProduction(Request $request){
        
        $content = $request->getContent();
        $data =  $request->all();
    }

    public function addEmailEntry($type,$email){

        $add = new EmailDelivery;
        $add->type = $type;
        $add->email = $email;
        $add->count = 1;
        $add->save();

        return $add ? 'true' : 'false';
    }

    public function getEmailCount($email){

        $emailCount = EmailDelivery::where('email',$email)->count();

        return $emailCount;
    }
}
