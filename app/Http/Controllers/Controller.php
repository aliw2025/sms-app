<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Mask;

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
            'message' => 'required|string',
            'mask'=>'required'
        ]);

        $str = $request->to;

        $numbers = [];
        $token = strtok($str, ",");
        array_push($numbers,$token);
        while ($token !== false)
        {
            
            $token = strtok(",");
            array_push($numbers,$token);
        }
        
    
        // Retrieve the SMS configuration from the .env file
        $username = env('SMS_USERNAME');
        $password = env('SMS_PASSWORD');
        $from = env('SMS_FROM');
        $apiUrl = env('SMS_API_URL');


        // Build the API URL with query parameters
        $url = $apiUrl . '?' . http_build_query([
            'Username' => $username,
            'Password' => $password,
            'From' => $from,
            'To' => $request->input('to'),
            'Message' => $request->input('message'),
        ]);

        // dd($url);
        // Send the GET request to the SMS API
        $response = Http::get($url);



        dd($response);
        // Check for a successful response and return accordingly
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'message' => 'SMS sent successfully!',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send SMS.',
            ], $response->status());
        }
    

    }
}
