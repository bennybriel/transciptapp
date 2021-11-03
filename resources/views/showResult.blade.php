<!DOCTYPE html>
<html lang="en">
<?php
  $p = \App\Helpers\AppHelper::instance()->GetDepartment($data[0]->programid);
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
 <form class=""  id=""  method="POST" action="{{ route('DisplayResult') }}">
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
                                <h1 class="h4 text-gray-900 mb-4">New Application</h1>
                            </div>
                        @if($data)
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="text" name="matricno" value="{{ $data[0]->matric }}" class="form-control form-control" id="exampleFirstName"
                                            placeholder="" readonly="true">
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="text" name="surname" value="{{ $data[0]->surname }}" class="form-control form-control" id="exampleFirstName"
                                            placeholder="" readonly="true">
                                    </div>
                                 </div>
                                  <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="text" name="othername" value="{{ $data[0]->othernames }}" class="form-control form-control" id="exampleFirstName"
                                            placeholder="" readonly="true">
                                    </div>
                                 </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                   @if($p==0)
                                       <input type="text" name="programme" 
                                         value="{{ \App\Helpers\AppHelper::instance()->GetDepartment($data[0]->programid) }}" class="form-control form-control" id="exampleFirstName"
                                            placeholder="" readonly="true">
                                    @else
                                    
                                           <select name="programme" id="programme" class="form-control form-control" required>
                                                        <option value="">Programme</option>
                                                       @foreach($dept as $dept)
                                                          <option value="{{ $dept->department }}">{{ $dept->department }}</option>
                                                       @endforeach
                                                 </select>
                                    @endif

                                    </div>


                                 </div>
                               <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="email" name="email" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Applicant Email">
                                    </div>                                                             
                                </div>
                                 <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="text" name="phone" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Applicant Phone">
                                    </div>                                                             
                                </div>
                                 <div class="form-group row">
                                          <div class="col-sm-10 mb-3 mb-sm-0">
                                            <label>Transcript Destination Country</label>
                                            <select name="countr" id="countr" class="form-control form-control" required>
                                                        <option value="">Country</option>
                                                       @foreach($cou as $cou)
                                                          <option value="{{ $cou->id }}">{{ $cou->country }}</option>
                                                       @endforeach
                                                 </select>
                                       </div>
                                     </div>
                                       <div class="form-group row">
                                          <div class="col-sm-10 mb-3 mb-sm-0">
                                          <label>Transcript Destination State</label>
                                            <select name="state" id="state" class="form-control form-control" required>
                                                 
                                            </select>
                                        </div>
                                     </div>
                             @else
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="text" name="matricno" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Matriculation Number" required="true">
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="text" name="surname" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Fullname" required="true">
                                    </div>
                                 </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="text" name="phone" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Phone" required="true">
                                    </div>
                                 </div>
                               <div class="form-group row">
                                    <div class="col-sm-10 mb-3 mb-sm-0">
                                    <input type="email" name="email" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Email" required="true">
                                    </div>                                                             
                                </div>
                                  <div class="form-group row">
                                          <div class="col-sm-10 mb-3 mb-sm-0">
                                            <select name="programme" id="programme" class="form-control form-control" required>
                                                        <option value="">Programme</option>
                                                       @foreach($dept as $dept)
                                                          <option value="{{ $dept->department }}">{{ $dept->department }}</option>
                                                       @endforeach
                                                 </select>
                                       </div>
                                 </div>
                                <div class="form-group row">
                                          <div class="col-sm-10 mb-3 mb-sm-0">
                                            <select name="countr" id="countr" class="form-control form-control" required>
                                                        <option value="">Transcript Destination Country</option>
                                                       @foreach($cou as $cou)
                                                          <option value="{{ $cou->id }}">{{ $cou->country }}</option>
                                                       @endforeach
                                                 </select>
                                       </div>
                                     </div>
                                       <div class="form-group row">
                                          <div class="col-sm-10 mb-3 mb-sm-0">
                                            <label>Transcript Destination State</label>
                                            <select name="state" id="state" class="form-control form-control" required>
                                              
                                            </select>
                                        </div>
                                     </div>
                        
                        @endif
                               
                         <button class="btn px-4" type="submit" style="background:#c0a062;color:#FFF">Submit </button>

                            <hr>
                           
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