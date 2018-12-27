<?php

namespace App\Http\Controllers\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Message as MessageResource;
use Mail;

class MessageController extends Controller
{
    public function mailSend(Request $request)
    {
        $data = new MessageResource($request);
        $name = $data->name;
        $email = $data->email;
        $text = $data->text;
        $subject = $data->subject;
        
        //validation
        $request->validate([
            'name' => 'required|max:75|min:3|string',
            'email' => 'required|email',
            'subject' => 'required|max:100',
            'text' => 'required'
        ]);
        
	//Send mail
        Mail::send(['text'=>'email'],['name'=>$name,"subject"=>$subject,'email'=> $email,'text'=> $text],function($message) use ($subject,$name){
            $message->to('kumarasiri@gmail.com', 'to backend')
                    ->subject($subject);
            $message->from('mobileapp@shraddha.lk','Message from: '.$name);

        });
        
        return response(NULL,200)
                  ->header('Content-Type', 'text/plain');
    }
    
    public function get(Request $request)
    {
    	return "Please use post request instead of get";
    }
    
}
