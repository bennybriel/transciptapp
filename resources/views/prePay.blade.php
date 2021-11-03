<!DOCTYPE html>
<html lang="en">
<?php
   $pty ="Transcript Fee";
   $rs = DB::SELECT('CALL GetApplicationListByID(?)',array($id));
   $rt = DB::SELECT('CALL GetApplicationListByID(?)',array($tid));
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

<body class="bg-gradient-prima">

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
                     <h2 style="color:red">Important information</h2>
                      <p style=" text-align:justify">Your Transaction Reference is given as <strong>{{ $ref }}  </strong>.
                       Please note this number will be used to track your application and payment.
                    </p>
                    <p>Kindly be made aware that specified Registration ID <strong> {{ $tkid }} </strong> belongs to <strong>{{ $name }}</strong></p>
                      Please click on 'Pay Now' button below to confirm your payment on behalf of the registration number and name indicated below.
                      <strong style="color:red">Please note payment made in error cannot be refunded</strong>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Payment Details
                                </h1>
                            </div>
                         
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                      <label><strong>Registration ID</strong></label>
                                      {{ $tkid }}
                                   </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                      <label><strong>Fullname</strong></label>
                                      {{ $name }}
                                   </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                      <label><strong>programme</strong></label>
                                      {{ $pro }}
                                   </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                      <label><strong>Payment Description</strong></label>
                                     <label>Transcript Application Fee</label>
                                   </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                      <label><strong>Transcript Fee</strong></label>
                                     <label>&#8358;@if($rt)  &#8358;{{ number_format(($rt[0]->amount),2)}} @endif</label>
                                   </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                      <label><strong>Courier Fee</strong></label>
                                     <label>@if($rs) &#8358;{{ number_format(($rs[0]->amount),2)}} @endif</label>
                                   </div>                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                      <label><strong>Total Amount</strong></label>
                                     <label>@if($rs && $rt) &#8358;{{ number_format(($rs[0]->amount + $rt[0]->amount),2)}} @endif</label>
                                   </div>                                    
                                </div>
                          <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                   
                          
                              <a href="{{ route('PayNow',[$id,$prod,$email,$name,$mat,$tid]) }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                              Pay Now
                                </a>


                                   </div>
                              </div>
                           </div>
                        

                               












                            <hr>
                           
                        </div>
                    </div>
                 </form>

                </div>
            </div>

        </div>
    </div>
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
</body>
</html>