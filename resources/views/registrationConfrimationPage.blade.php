@extends('layouts.appfront')
@section('content')
 
    <div class="container">
    <div class="row" style="align:center">
         <div class="col-4">
         </div>
         <div class="col-7">
             <img src="dashboard/img/logo_transcript.png" style="max-width:100%;height:auto;"/>
         </div>

      </div>
      
      <br/>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h3 style="color:#da251d">Registration Confirmation</h3>
                  <p class="text-muted" style="color:#000000"></p>
                  <p style="color:#da251d"><em>Congratulations!!!, Your have successfully submitted Application.
                     
                    </p>
             
                  <p><h6 style="color:#da251d">For Complaints</h6>
                  Call +2348079038989, +2349094507494 <br/>
                  OR Email to support@lautech.edu.ng
                  </p>
                </div>
              </div>
            
           
          </div>
        </div>
      </div>
    </div>
 <?php
    Auth::logout();
    Session::flush();
 ?>
    @endsection

