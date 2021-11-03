<?php
namespace App\Helpers;
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
class AppHelper
{
      public function bladeHelper($someValue)
      {
             return "increment $someValue";
      }

     public function startQueryLog()
     {
           \DB::enableQueryLog();
     }

     public function showQueries()
     {
          dd(\DB::getQueryLog());
     }

     public static function instance()
     {
         return new AppHelper();
     }
    public function GetDepartment($dep)
     {
       $de ="";
       $dat = DB::table('programme')->where('programid', $dep)->get()->first();
       if($dat)
       {
        return $dat->program;
       }
       else
       {
        return 0;
       }
      
   }
}