<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Mask;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index(){

            
        $masks = Mask::where('active',1)->get();

        return view('send-msg',compact('masks'));

    } 


    public function sendSms(Request $request){
        
    
        $request->validate([
            'to' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
            'mask'=>'required'
        ]);

        $string = $request->to;
        $cleanString = str_replace('', ' ', $string);
        $numbers = explode(' ', $cleanString);

        // Retrieve the SMS configuration from the .env file
        $username = env('SMS_USERNAME');
        $password = env('SMS_PASSWORD');
        $from = env('SMS_FROM');
        $apiUrl = env('SMS_API_URL');

        $successStr = 'Message Sent Successfully!';
        $failed = 0;
        $success = 0;

        $tran = new Transaction();
        $tran->subject =  $request->subject;
        $tran->num_of_contacts  = length($numbers);
        $tran->num_of_successfull =0;
        $tran->num_of_failed =0;
        $tran->save();

        foreach ($numbers as $number) {
            
            $url = $apiUrl . '?' . http_build_query([
                'Username' => $username,
                'Password' => $password,
                'From' => $from,
                'To' => $request->$number,
                'Message' => $request->input('message'),
            ]);
            
            $response = Http::get($url);
            $tranDetail = New TransactionDetail();
            $tranDetail->transaction_id = $tran->id;
            $tranDetail->contact = $number;
            $tranDetail->response_code = $response;

            if($response==$successStr){
                $success = $success+1;
                $tranDetail->sms_status_id = 1;
            }else{
                $failed = $failed+1;
                $tranDetail->sms_status_id = 0;
            }
            $tranDetail->save();

        }
        $tran->num_of_contacts  = length($numbers);
        $tran->num_of_successfull = $success;
        $tran->num_of_failed = $failed;
        $tran->save();
       
        
        if ($failed>0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send SMS.',
               
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'SMS sent successfully!',
            ]);
        }
    
    }

}
