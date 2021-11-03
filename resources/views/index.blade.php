@extends('layouts.appfront')
@section('content')
<?php
   
    $dt ="";
    $res ="";
    try
    {
      $client = new \GuzzleHttp\Client();
      $url    = config('paymentUrl.product_id_url_all');   
      $response =$client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
     
      // or can use
      // $guzzleResponse = $client->request('GET', '/foobar')
        if ($response->getStatusCode() == 200) {
            // $response = json_decode($guzzleResponse->getBody(),true);
             $res = json_decode($response->getBody());
             //perform your action with $response 
        } 
    }
    catch(\GuzzleHttp\Exception\RequestException $e){
       // you can catch here 400 response errors and 500 response errors
       // You can either use logs here use Illuminate\Support\Facades\Log;
       $error['error'] = $e->getMessage();
       $error['request'] = $e->getRequest();
       if($e->hasResponse()){
           if ($e->getResponse()->getStatusCode() == '400'){
               $error['response'] = $e->getResponse(); 
           }
       }
       Log::error('Error occurred in get request.', ['error' => $error]);
    }
    catch(Exception $e){
       //other errors 
    }
  
    //dd($res);
    if($res)
    {
       foreach($res as $res)
       {
           // dd($res->amount);
           //Check Duplications
            $rem="readme".$res->id.'.pdf';
            $ck = DB::SELECT('CALL CheckDuplicatedApplicationList(?)', array($res->id));
            if($ck)
             {
                 $up =DB::UPDATE('CALL UpdateApplicationList(?,?,?,?,?)', 
                 array($res->session,$res->amount,$res->name,$rem,$res->id));
             }
            else
              {
                
                $setrec = DB::INSERT('CALL SaveApplicationList(?,?,?,?,?)', 
                array($res->id,$rem,$res->amount,$res->name,$res->session));
              }
       }
    }
    
?>
<div class="container">
    <br/> 
<div class="row">
     <div class="col-4">
     </div>
     <div class="col-6">
        <img src="dashboard/img/logo_transcript.png" style="max-width:100%;height:auto;"/>
     </div>
  </div>
 <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    
                    <div class="col-lg-9">
                        <div class="p-5">
                            <p style="text-align:justify; "><strong style="color:#c0a062">PLEASE READ THE INFORMATION BELOW.</strong> By proceeding to APPLY, it means you have understood all that is written in this guide. If you have further inquires please <a href="">contact us.</a></p>

                            <h3 style="color:#da251d"><strong>How to Apply</strong></h3>
                            <p style="text-align:justify;">
                            <li>Click on "Apply for Transcript" and Search Up your Matriculation Number</li>
                            <li>Supply a Valid Email Address and Phone Number. This is important because we may need to reach you.</li>
                             <li>Select the number of copies you need. That is, the number of transcripts that should be sent to a particular destination.</li>
                             <li>You will then be directed to make payment. The Fee Schedule is below.</li>
                             <li>After a successful payment, please take note of your transaction reference. This will also serve as your tracking number for your application and the only means by which you can retrieve or track your application</li>
                             <li>After a successful payment, you can now proceed to fill the transcript details by clicking on "Fill Transcript Details"</li>
                             <li>After submission of your transcript details, an email will be sent to you on how to track your application.</li>
                             <li>If you were unable to complete your transcript application process once, and you want to continue from where you stopped OR you need to track an already completed application, then click on "Retrieve/Track an Application" </li></p>

                            <h3><strong style="color:#da251d">Fee Schedule</strong></h3>
                             Transcript Application & Processing &#8358;{{ number_format(5000,2) }}
                             <br/>

                            <strong>Courier Service within Nigeria</strong>
                            <li>South West &#8358;{{ number_format(1700,2) }} (per destination)</li>
                            <li>Others  &#8358;{{ number_format(3500,2) }} (per destination)</li>

                            <strong>Courier Service for outside Nigeria</strong> &#8358;{{ number_format(12000,2) }}(per destination)

                            <li>All Fees are payable via the LAUTECH InterSwitch Payment Integration Platform</li>
                            <li>Note that a bank transaction charge of &#8358;{{ number_format(300,2) }} per transaction apply for all transactions</li>
                             <p style="text-align:justify; ">You will be redirected to Interswitch gateway during registration to make payment. Prepare for making your payment online by having the following information handy:</p>

                            <li>An Interswitch enabled Debit/ ATM card, specifying the “Card Number”, “Expiry Date”, “Card PIN” and “CVV2 Code” </li>
                            <li>Ensure that you have sufficient funds in the card specified above, to cater for your fees as quoted in this section</li>
                                <strong style="color:#da251d">Contact Us</strong><br/>
                                <em><strong>Working Hours: 8am - 4pm, Work days</strong></em><br/>
                                <em><strong>Email Address: transcript@lautech.edu.ng</strong></em> </p>
                         </div>
                       
                    </div>
                    <div class="col-lg-3">
                        <div class="p-4">
                           <strong style="color:#da251d">Menu</strong>
                           <hr/>
                            <strong><a href="{{ route('applyNow') }}">Apply Now</a></strong><br/>
                            <hr/>
                            <strong><a href="{{ route('checkPaymentStatus') }}">Check Payment Status</a></strong><br/>
                               <hr/>
                            <strong><a href="{{ route('completeApp') }}">Complete Application </a></strong><br/>
                             <hr/>
                            <strong><a href="{{ route('getTranscriptID') }}">Retrieve Transcript ID </a></strong><br/>
                            <hr/>
                              <strong style="color:#da251d">Other Lautech Sites</strong><br/>
                              <hr/>
                              <strong><a href="https://lautech.edu.ng" target="_blank">Main Site</a></strong><br/>
                              <hr/>
                               <strong><a href="">Postgraduate Transcript</a></strong><br/>
                              <hr/>
                              <hr/>
                               <strong><a href="https://transcript.lautech.edu.ng/odl" target="_blank">ODL Transcript</a></strong><br/>
                              <hr/>
                               <strong><a href="">Convocation Payment</a></strong><br/>
                              <hr/>
                               <strong><a href="">Student Portal</a></strong><br/>
                              <hr/>
                               <strong><a href="">University News</a></strong><br/>
                              <hr/>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
@endsection