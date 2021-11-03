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
use App\Mail\RegEmail;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function GetTranscriptIDs(Request $request)
    {
       if($request)
       {

            $matricno = $request->input('matricno');
            if (Auth::attempt(['matricno' => $matricno, 'password' => $matricno]))
            {
                    $email = Auth::user()->email;
                    $data =  DB::SELECT('CALL GetTranscriptID(?)', array($matricno));
                    if($data)
                    {
                        $details =
                        [   'title'=>"",
                            'body'=>"Thank you for requesting for your Transcript ID.",
                            'parts'=>"Your transcript ID ".$data[0]->transcriptid, 
                            'team'=>"Support email:support@lautech.edu.ng",
                        ];
                        Mail::to(strtolower($email))->send(new RegEmail($details));
                        return back()->with('success', 'Congratulation!!!, Your Transcript ID Has Been Sent To Email');
                    }
                    else
                    {
                        return back()->with('error', 'Sorry, No Record Found, Please Retry Again');
                    }         
            }
            else
            {
                return back()->with('error', 'Sorry, Matric Number Not Found, Please Try Again');
            }

       }
       else
       {
         return back()->with('error', 'Operation Failed, Please Retry Again');
       }
    }
    public function GetTranscriptID()
    {
        return view('getTranscriptID');
    }
   public function CompleteApplications(Request $request)
    {
       if($request)
       {

            $matricno = $request->input('matricno');
            if (Auth::attempt(['matricno' => $matricno, 'password' => $matricno]))
            {
                
                    $data =  DB::SELECT('CALL GetUnusedPayment(?)', array($matricno));
                    if($data)
                    {
                        return view('dataInfo',['tra'=>$data[0]->transactionid]);
                    }
                    else
                    {
                        return back()->with('error', 'Sorry, No Unused Payment/Transaction For This Account, Please Retry Again');
                    }         
            }
            else
            {
                return back()->with('error', 'Sorry, Matric Number Not Found, Please Retry Again');
            }

       }
       else
       {
         return back()->with('error', 'Operation Failed, Please Retry Again');
       }
    }
    public function CompleteApp()
    {
        return view('completeApp');
    }
  
   public function RegConfirmation()
   {
            if(Auth::check())
            {
                return view('registrationConfrimationPage');
            }
            {
                return view('index');
            }
   }
     public function DataInfos(Request $request)
     {

        if(Auth::check())
        {
            $label ="";
            $matricno = Auth::user()->matricno;
            $email = Auth::user()->email;
            $name = $request->name;
            $org =$request->org;
            $email =$request->email;
            $phone =$request->phone;
            $lab = $request->label;
            $address =$request->address;
            $spl = explode(PHP_EOL, $address);
            //dd($skuList);
            $adr1 =  $spl[0];
            $adr2 =  $spl[1];
     
            $tra =$request->tra;
            $tid = $matricno.substr(mt_rand(11, 99999999) . mt_rand(111, 9999999) . mt_rand(1111, 9999), 1, 4);
            if($lab)
            {
               $label =$lab;
            }
            else
            {
                $label =$name;
            }
                    //Check Multiple Entry
                    $ck = DB::SELECT('CALL CheckDuplicateRecipentInfo(?,?)',array($matricno,$org));
                    if($ck)
                    {
                        //return back()->with('error', 'Information Already Received, Please Retry Again');
                        return redirect()->route('registrationConfrimationPage'); 
                    }
              //Upload Transcript label
               $file_path = $request->file('filelabel');
               if($file_path)
               {
                    $input['imagename'] = $tid.'-'.$matricno.'.'.$file_path->getClientOriginalExtension();       
                    $destinationPath = public_path('/uploads/TranscriptLabel/');     
                    $file_path->move($destinationPath, $input['imagename']); 
                    $imgP=$input['imagename'];
                    $myfile_path=$imgP;
                    $filetype="Transcript Label ".$tid.'-'.$matricno;
                    $fname = $tid.'-'.date('d-m-Y');
                
                   
                    $sav = DB::INSERT('CALL SaveReceipentInfo(?,?,?,?,?,?,?,?,?,?,?)',
                    array($matricno,$name,$org,$phone,$email,$adr1,$adr2,$label,$tid,$tra,$myfile_path));       
                    
                    if($sav)
                    {
                        #Update the Used Status of the Payment
                        DB::UPDATE('CALL UpdateDestinationWithTranscriptID(?,?)',array($matricno,$tid));
                        DB::UPDATE('CALL PaymentUsedStatus(?)',array($tra));
                        $details =
                                [   'title'=>"",
                                    'body'=>"Thank you for applying for Transcript.",
                                    'parts'=>"Your transcript application has been received successfully.  Your Transcript ID is ".$tid, 
                                    'team'=>"Support email:support@lautech.edu.ng",
                                ];
                         Mail::to(strtolower($email))->send(new RegEmail($details));
                         
                        $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($matricno,$filetype,$myfile_path,$fname)); 
                        return redirect()->route('registrationConfrimationPage'); 
                    }
               }
               else
               {
                 // 
                    $input['imagename'] = $tid.'-'.$matricno;       
                    $destinationPath = public_path('/uploads/TranscriptLabel/');     
                   // $file_path->move($destinationPath, $input['imagename']); 
                    $imgP=$input['imagename'];
                    $myfile_path=$imgP;
                    $filetype="Transcript Label ".$tid.'-'.$matricno;
                    $fname = $tid.'-'.date('d-m-Y');
                     //dd($myfile_path);
                      $sav = DB::INSERT('CALL SaveReceipentInfo(?,?,?,?,?,?,?,?,?,?,?)',
                      array($matricno,$name,$org,$phone,$email,$adr1,$adr2,$label,$tid,$tra,"None"));          
                    
                    if($sav)
                    {
                        #Update the Used Status of the Payment
                        DB::UPDATE('CALL UpdateDestinationWithTranscriptID(?,?)',array($matricno,$tid));
                        DB::UPDATE('CALL PaymentUsedStatus(?)',array($tra));
                        $details =
                                [   'title'=>"",
                                    'body'=>"Thank you for applying for Transcript.",
                                    'parts'=>"Your transcript application has been received successfully.  Your Transcript ID is ".$tid, 
                                    'team'=>"Support email:support@lautech.edu.ng",
                                ];
                         Mail::to(strtolower($email))->send(new RegEmail($details));
                        $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($matricno,$filetype,$myfile_path,$fname)); 
                        return redirect()->route('registrationConfrimationPage'); 
                    }
                }

        }
        else
        {
            return view('index');
        }
    }
    
    
    public function DataInfo()
    {
        if(Auth::check())
        {
            return view('dataInfo');
        }
        {
            return view('index');
        }
    }
    public function ShowTranscript()
    {
        ini_set('max_execution_time', 300);
        $mat ="040508";
        $data = DB::SELECT('CALL GetTranscriptByMatricNo(?)', array($mat));   
      
        $result = ['data'=>$data];
                     PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                    // pass view fil
                      $pdf = PDF::loadView('showTranscript',$result);
                      //return $pdf;
                     return $pdf->download($mat.'.pdf');
        return view('showTranscript');
    }
     public function TrackApplication(Request $request)
     {
       if($request)
       {

            $matricno = $request->input('trackid');
            if (Auth::attempt(['matricno' => $matricno, 'password' => $matricno]))
            {
                
                    $data =  DB::SELECT('CALL GetUnusedPayment(?)', array($matricno));
                    if($data)
                    {
                        return view('dataInfo',['tra'=>$data[0]->transactionid]);
                    }
                    else
                    {
                        return back()->with('error', 'Sorry, No Unused Payment/Transaction For This Account, Please Retry Again');
                    }         
            }
            else
            {
                return back()->with('error', 'Sorry, Matric Number Not Found, Please Retry Again');
            }

       }
       else
       {
         return back()->with('error', 'Operation Failed, Please Retry Again');
       }
    }
    
    public function TrackingNow()
    {
        return view('trackApp');
    }
    public function DisplayResult(Request $request)
    {
        $coamt =0;
        $amt =0; $id =0;
        if($request)
        {
            $surname   = $request->input('surname');
            $othername = $request->input('othername');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $countr = $request->input('countr');
            $state = $request->input('state');
            $programme = $request->input('programme');
            $matricno = $request->input('matricno');
            $name =$surname . '  '.$othername;
            $tkid = substr(mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999), 1,6);
            $ref  = substr(mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 999999999), 1,10);
            #Get courrier by state
            //$co = DB::SELECT('CALL GetCourrierByState(?)',array($state));
            $name =  $surname. ' '.$othername;
            $prod ="Tanscript Application";
            $co = DB::SELECT('CALL GetCourrierByState(?)',array($state));
            if($countr=='153')
            {
                if($co)
                {
                  $id=22;
                }
                else
                {
                  $id=23;
                }
            }
            else 
            {
                $id =24;
                # code...
            }
             //$tid = 25;
             $ck = DB::SELECT('CALL CheckDuplicateApplication(?,?,?)',array($matricno,$state,$countr));
            if($ck)
            {
                
                 if (Auth::attempt(['matricno' => $matricno, 'password' => $matricno]))
                 {
                       DB::INSERT('CALL SaveDestinationInfo(?,?,?,?)',array($matricno,$phone,$countr,$state));
                       return view('home', ['mat'=>$matricno,
                                    'name'=>$name,
                                    'pro' =>$programme,
                                    'email'=>$email,
                                    'tkid'=>$tkid,
                                    'ref' =>$ref,
                                    'id'=>$id,
                                    'prod'=>$prod
                                  ]);
                }
            }
           $sav = DB::INSERT('CALL SaveTranscriptApplication(?,?,?,?,?,?,?,?,?)',array($matricno,$email,$phone,$countr,$state,$tkid,$ref,$amt,$programme));
           if($sav)
           {
                $cks = DB::SELECT('CALL CheckAccountSignupDuplicateByMatricNo(?)',array($matricno));
                if($cks[0]->Mat==0)
                {
                    #Create User Account
                    $pw = Hash::make($matricno);
                    DB::INSERT('CALL CreateStudentAccount(?,?,?,?)',
                    array($name,$email,$pw,$matricno));
                }

                if (Auth::attempt(['matricno' => $matricno, 'password' => $matricno]))
                {
                      DB::INSERT('CALL SaveDestinationInfo(?,?,?,?)',array($matricno,$phone,$countr,$state));
                       return view('home', ['mat'=>$matricno,
                                    'name'=>$name,
                                    'pro' =>$programme,
                                    'email'=>$email,
                                    'tkid'=>$tkid,
                                    'ref' =>$ref,
                                    'id'=>$id,
                                   
                                    'prod'=>$prod
                                  ]);
                }
           }
           else
           {
               return back()->with('error', 'Operation Failed, Please Retry Again');
           }

        }

    }
    
    public function GetState($id="")
     {
         
          //dd($id);
           //Fetch Employees by Departmentid
           //  $empData['data'] = ClassSetup::orderby("ClassName","asc")
             $empData['data'] = DB::SELECT('CALL GetStateByCountryID(?)', array($id));
             return response()->json($empData);
        
     }
    public function ConfirmMatricNo(Request $request)
    {
        if($request)
        {
            $cou = DB::SELECT('CALL FetchCountries()');
            $matricno = $request->input('matricno');
            $data = DB::SELECT('CALL GetUserMatricNo(?)', array($matricno));
            $dept = DB::SELECT('CALL FetchDepartment()');
            return view('showResult',['data'=>$data, 'cou'=>$cou,'dept'=>$dept]);
        }

    }
    public function ApplyNow()
    {
        return view('applyNow');
    }
    
    public function index()
    {
        //
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
