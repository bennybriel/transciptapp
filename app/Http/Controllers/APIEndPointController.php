<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\ApprovalEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class APIEndPointController extends Controller
{
    //
 
     public function GetTotalCompleteApp()
     {
        $data = DB::SELECT('CALL GetTotalCompleteApplication()');
        if($data)
        {
            $message='Data Fetched';
              $response = [
                'success' => true,
                'data'    => $data,
                'message' => $message,
            ];
    
            return response()->json($response, 200);
            
        }
        else
        {    $msg = "Fetching Failed...";
            // return json_encode(array("statusCode"=>201,'msg'=>$msg));
            $code = 404;
            $response = [
                'error' => false,
                'message' => $msg,
            ];
    
            if(!empty($msg)){
                $response['data'] = $msg;
            }
    
            return response()->json($response, $code);
        }
    }
    public function GetPaidTranscripts()
    {
        $data = DB::SELECT('CALL GetPaidTranscript()');
        if($data)
        {
            $message='Data Fetched';
              $response = [
                'success' => true,
                'data'    => $data,
                'message' => $message,
            ];
    
            return response()->json($response, 200);
            
        }
        else
        {    $msg = "Fetching Failed...";
            // return json_encode(array("statusCode"=>201,'msg'=>$msg));
            $code = 404;
            $response = [
                'error' => false,
                'message' => $msg,
            ];
    
            if(!empty($msg)){
                $response['data'] = $msg;
            }
    
            return response()->json($response, $code);
        }
    }
    public function GetTranscript()
    {
        $data = DB::SELECT('CALL GetRegisteredTranscript()');
        if($data)
        {
            $message='Data Fetched';
              $response = [
                'success' => true,
                'data'    => $data,
                'message' => $message,
            ];
    
            return response()->json($response, 200);
            
        }
        else
        {    $msg = "Fetching Failed...";
            // return json_encode(array("statusCode"=>201,'msg'=>$msg));
            $code = 404;
            $response = [
                'error' => false,
                'message' => $msg,
            ];
    
            if(!empty($msg)){
                $response['data'] = $msg;
            }
    
            return response()->json($response, $code);
        }
    }
}
