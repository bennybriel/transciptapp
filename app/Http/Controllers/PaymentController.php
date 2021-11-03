<?php

namespace App\Http\Controllers;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportsTranscriptApps;

class PaymentController extends Controller
{
    //
    
    public function DownloadTranscriptInfo()
    {
       //dd($sess);
            $uuid = Str::uuid()->toString();
            return Excel::download(new ExportsTranscriptApps, $uuid.'.xlsx');
       
    }
    public function CheckPayStatus(Request $request)
      {
          if($request)
           {   
                $matricno =$request->matricno;
                if (Auth::attempt(['matricno' => $matricno, 'password' => $matricno]))
                {
                     
                        $res ="Pending";
                        $client = new \GuzzleHttp\Client();
                        $pd  = DB::SELECT('CALL ValidatePendingTransaction(?,?)',array($matricno,$res));
                     //  dd($pd);
                        foreach($pd as $pd)
                        {
                            
                            $url = config('paymentUrl.trans_status_url').$pd->transactionid;
                            //d
                            $response = $client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
                            $res = json_decode($response->getBody());
                            //dd($res);
                            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($res)));
                                if($res)
                                {
                                          if($res->status=="Approved Successful")
                                          {  
                                             
                                                   if($pd->isused==false)
                                                    {
                                                        $sav = DB::UPDATE('CALL UserIspaidStatus(?,?)',array($pd->transactionid,$res->status)); 
                                                        return view('dataInfo',['tra'=>$pd->transactionid]);
                                                    }
                                                    else
                                                    {
                                                       
                                                        $sav = DB::UPDATE('CALL UserIspaidStatus(?,?)',array($pd->transactionid,$res->status)); 
                                                        return back()->with('success', ' Payment Status '.$res->status);
                                                    } 
                                                                          
                                          }
                                          else
                                          {
                                                DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($pd->transactionid, $res->status, $matricno));
                                                return back()->with('error', ' Payment Status '.$res->status);
                                          }
                                  }
                          }//loop
                           return back()->with('error', 'No Information Find, Please Try Again');
                          
                         
                }
                else
                {
                    return back()->with('error', 'User Account Not Found, Please Try Again');
                }
            }

    }
    public function CheckPay()
    {
        return view('checkPaymentStatus');
    }
    public  function PayNow($id,$prod,$email,$name,$mat)
    {
       //dd($id);
            $client = new \GuzzleHttp\Client();
            $matricno =$mat;
            $apptype = "";
            $transID = "";
          
                try
                 {
                    $transID = "TRA21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    $apptype="TRA";
                    $prod    = DB::SELECT('CALL GetApplicationListByID(?)', array($id));

                   
                    if ($prod) //($res)
                    {
                        //$p = "Pending";
                       // $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?)', array($matricno, $id));
                       
                        //if (!$ck)
                         //{
                         
                                $sav = DB::INSERT('CALL CreateStudentPaymentAccount(?,?,?,?,?,?)',
                                array($matricno, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype));
                         // } 
                   /*
                        else 
                        {
                           
                            #Get Pending Transaction ID
                            $tra     = DB::SELECT('CALL GetPendingTransactionID(?,?)', array($matricno, $p));
                           
                            if ($tra) 
                            {
                                $transID = $tra[0]->transactionid;
                             
                              
                            } 
                            else 
                            {
                                # code...
                                $sav = DB::INSERT(
                                    'CALL CreateStudentPaymentAccount(?,?,?,?,?,?)',
                                    array($matricno, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype)
                                );
                                
                            }
                        }
                    */
                       
                    } 
                    else 
                    {
                        //return redirect()->route('home');
                        return back()->with('error', 'Payment Details Not Found,
                             Invalid Payment Parameters Supplied For ' . $prod);
                    }

                                
                } 
                catch (RequestException $re)
                 {
                    return back()->with('error', 'Payment Gateway Temporarily Not Available For ' . $prod .
                        '. Please Try Again Later!');
                }
            

            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');
         
            //dd(config('paymentUrl.returning_url'));
            $parameters = array(
                "product_id" => $id,
                "trans_ref" => $transID,
                "user_email" =>$email,
                "user_number" => Auth::user()->matricno,
                "user_number_desc" => "Full Name",
                "returning_url" => config('paymentUrl.returning_url') . $uuid,
            );

            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
            );
            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($parameters)));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
           
            //var_dump($resp);
            DB::INSERT('CALL SaveRequestLogger(?)',array($resp));
            $res = json_decode($resp);
            
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } 
        public function randomPassword()
        {
            $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 5; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            //return implode($pass); //turn the array into a string
            return implode($pass);
        }
    }

