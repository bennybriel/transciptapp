<!DOCTYPE html>
<html lang="en">
<?php
   $mat = Auth::user()->matricno;
   $data = DB::SELECT('CALL GetApplicationInfo(?)',array($mat));
   if(!$tra)
    {
      $tras = DB::SELECT('CALL GetCurrentTransactionID(?)',array($mat));
    }
   
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Transcript Portal-Application</title>

    <!-- Custom fonts for this template-->
    <link href="dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="dashboard/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<style>
    table {
    border-collapse: collapse;
    }

    td, th {
    border: 1px solid #999;
    padding: 0.5rem;
    text-align: left;
    }

    {
  box-sizing: border-box;
}

/* Create two unequal columns that floats next to each other */
.column {
  float: left;
  padding: 10px;
  height: 30px; /* Should be removed. Only for demonstration */
}

.left {
  width: 25%;
}

.right {
  width: 75%;
}
.lefts {
  width: 50%;
}

.rights {
  width: 50%;
}


/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.noBorder {
    border:none !important;
    font-weight: bold;
}
.noBorder1 {
    border:none !important;
}
</style>

<body class="bg-gradient-prima">
 <form class=""  id=""  enctype="multipart/form-data"  method="POST" action="{{ route('DataInfos') }}">
     {{ csrf_field() }}
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
                <div class="col-lg-5 d-none d-lg-block bg">
                    <div class="p-5">
                         <h4 style="color:#000000">Important information</h2>
                      <p style=" text-align:justify">If you were unable to complete your transcript application process once, and you want to continue from where you stopped OR you need to track an already completed application, then click on "Retrieve/Track an Application".</p>
                        </div>
                    </div>
                   
                    <div class="col-lg-7">
                                             @if(Session::has('error'))
                                                 <div class="alert alert-danger">
                                                        {{ Session::get('error') }}
                                                        @php
                                                            Session::forget('error');
                                                        @endphp
                                                        </div>
                                                   @endif
                                                        @if(Session::has('success'))
                                                     <div class="alert alert-success">
                                                        {{ Session::get('success') }}
                                                        @php
                                                            Session::forget('success');
                                                        @endphp

                                                        </div>

                                                @endif

                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Complete Transcript Application</h1>
                            </div>
                            @if($tra)
                                <input type="hidden" name="tra" value="{{ $tra }}" />
                            @else
                               <input type="hidden" name="tra" value="{{ $tras[0]->transactionID }}" />
                             @endif
                             <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                       <label>Receipent Contact Person</label>
                                    <input type="text" name="name"  class="form-control form-control" id="exampleFirstName"
                                            placeholder="Receipent Contact Person" required/>
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <label>Receipent Organisation</label>
                                    <input type="text" name="org"  class="form-control form-control" id="exampleFirstName"
                                            placeholder="Receipent Organisation"required/>
                                    </div>
                                    
                                </div>
                               <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                       <label>Receipent Email</label>
                                       <input type="email" name="email" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Receipent Email" required/>
                                    </div>                                                             
                                </div>
                                 <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <label>Receipent Phone</label>
                                    <input type="text" name="phone" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Receipent Phone"required/>
                                    </div>                                                             
                                 </div>
                                 <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <label>Receipent Address</label>
                                           <textarea name="address" cols="10" rows="2" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Receipent Address" required></textarea>
                                   
                                    </div>                                                             
                                 </div>
                                 <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <label>Transcript Label</label>
                                       <input type="text" name="label" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Transcript Label"/>
                                        <label>Upload Transcript Label (If Any)</label>
                                        <input type="file" name="filelabel" class="form-control form-control"
                                                 id="exampleFirstName" >
                                    </div>                                                             
                                 </div>

                                 <div class="form-group row">
                                          <div class="col-sm-10 mb-3 mb-sm-0">
                                            <label>Destination Country</label>
                                            @if($data)
                                              <input type="text" name="country" value="{{ $data[0]->country }}" class="form-control form-control" id="exampleFirstName" readonly/>
                                            @endif
                                       </div>
                                     </div>
                                       <div class="form-group row">
                                          <div class="col-sm-10 mb-3 mb-sm-0">
                                             <label>State</label>
                                             @if($data)
                                              <input type="text" name="state" value="{{ $data[0]->state }}" class="form-control form-control" id="exampleFirstName" readonly/>
                                            @endif
                                        </div>
                                     </div>
                               
                                    <button class="btn px-4" type="submit" style="background:#c0a062;color:#FFF">Submit </button>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="" style="color:#da251d">Click To Retrieve Application</a>                            </div>
                            <div class="text-center">
                                <a class="small" href="" style="color:#000">Clic To Track Application</a>                            </div>
                        </div>
                    </div>
               
                </div>
            </div>

        </div>
    </div>
</form>


     <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                       Copyright © 2021 LAUTECH ICT. All rights reserved.
                    </div>
                </div>
            </footer>

    <!-- Bootstrap core JavaScript-->
    <script src="dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="dashboard/js/sb-admin-2.min.js"></script>
    <script src="js/jquery-3.3.1.js"></script>
<script type='text/javascript'>
$(document).ready(function()
{
   
  $('#countr').change(function()
  {
  
     
     var id = $(this).val();
     var oth ="Others";
     // Empty the dropdown
     $('#state').find('option').not(':first').remove();
      //alert(id);

     $.ajax({
       url: 'GetState/'+id,
       type: 'get',
       dataType: 'json',
       success: function(response){

         var len = 0;
         if(response['data'] != null)
         {
           len = response['data'].length;
         }

         if(len > 0){
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id   = response['data'][i].stateid;
             var name = response['data'][i].name;

             var option = "<option value='"+name+"'>"+name+"</option>"

             $("#state").append(option); 
            
           }
         }
         else
         {
             var option = "<option value='0'>"+oth+"</option>"

             $("#state").append(option); 
         }

       }
    });
  });

});
</script>
</body>
</html>