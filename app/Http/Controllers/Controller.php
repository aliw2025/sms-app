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
use App\Enums\SmsStatus;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

            
        $masks = Mask::where('active',1)->get();
        return view('send-msg',compact('masks'));
        
    } 

    public function fetchTransactions(Request $request)
    {
        $columns = ['id', 'subject', 'num_of_contacts', 'num_of_successfull', 'num_of_failed', 'created_at'];

        $totalData = Transaction::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $transactions = Transaction::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $transactions = Transaction::where('subject', 'LIKE', "%{$search}%")
                ->orWhere('num_of_contacts', 'LIKE', "%{$search}%")
                ->orWhere('num_of_successfull', 'LIKE', "%{$search}%")
                ->orWhere('num_of_failed', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Transaction::where('subject', 'LIKE', "%{$search}%")
                ->orWhere('num_of_contacts', 'LIKE', "%{$search}%")
                ->orWhere('num_of_successfull', 'LIKE', "%{$search}%")
                ->orWhere('num_of_failed', 'LIKE', "%{$search}%")
                ->count();
        }
        $baseUrl = url('transaction-details');

        $data = [];
        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                $nestedData['id'] = $transaction->id;
                $nestedData['subject'] = $transaction->subject;
                $nestedData['num_of_contacts'] = $transaction->num_of_contacts;
                $nestedData['num_of_successfull'] = $transaction->num_of_successfull;
                $nestedData['num_of_failed'] = $transaction->num_of_failed;
                $nestedData['created_at'] = date('j M Y h:i a', strtotime($transaction->created_at));
                $nestedData['details'] = '<a href="' . $baseUrl . '/' . $transaction->id . '" class="btn btn-primary"> Details</a>'; // Generate the HTML link here

                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }
    public function history(){

        return view('history');
    }
    public function showDetails($id)
    {
        $transaction = Transaction::findOrFail($id);
        $details = TransactionDetail::where('transaction_id', $id)->get();
        
        return view('transaction-details', compact('transaction', 'details'));
    }

    public function sendSms(Request $request){
        
    
        $request->validate([
            'to' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
            'mask'=>'required'
        ]);

        // dd($request->all());
        $string = $request->to;
        $cleanString = str_replace('', ' ', $string);
        $numbers = explode(',', $cleanString);
        $mask = $request->mask;
        $message = $request->message;
        // dd($mask);
        // Retrieve the SMS configuration from the .env file
        $username = env('SMS_USERNAME');
        $password = env('SMS_PASSWORD');
        $apiUrl = env('SMS_API_URL');

        $successStr = 'Message Sent Successfully!';
        $failed = 0;
        $success = 0;

        $tran = new Transaction();
        $tran->subject =  $request->subject;
        $tran->num_of_contacts  = count($numbers);
        $tran->num_of_successfull =0;
        $tran->num_of_failed =0;
        $tran->save();
        
       
        
        

        foreach ($numbers as $number) {
            
         
            $url = $apiUrl.'?Username='.$username.'&Password='.$password.'&From='.$mask.'&To='.$number.'&Message='.$message;
        //    dd($url);
            $ch = curl_init(); 
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $output=curl_exec($ch);
            
            
            // curl_close($ch);
            // dd('Done');
            $tranDetail = New TransactionDetail();
            $tranDetail->transaction_id = $tran->id;
            $tranDetail->contact = $number;
            $tranDetail->response_code = $output;
            if(curl_errno($ch))
            {   
                $tranDetail->response_code =curl_error($ch);
               
            }

            if($output==$successStr){
                $success = $success+1;
                $tranDetail->sms_status_id =  2;
            }else{
                $failed = $failed+1;
                $tranDetail->sms_status_id =  1;
            }
            $tranDetail->save();

        }
        $tran->num_of_contacts  = count($numbers);
        $tran->num_of_successfull = $success;
        $tran->num_of_failed = $failed;
        $tran->save();
        
        if ($failed>0) {
            return response()->json([
                'status' => 'error',
                'message' => 'sent: '.$success.' Failed: '.$failed,

            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'SMS sent successfully!',
            ]);
        }
    
    }

}
