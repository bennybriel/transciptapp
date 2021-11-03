<!DOCTYPE html>
<html lang="en">

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
                         <h4 style="color:#000000">Important information</h2>
                      <p style=" text-align:justify">If you were unable to complete your transcript application process once, and you want to continue from where you stopped OR you need to track an already completed application, then click on "Retrieve/Track an Application".</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Check Payment Status</h1>
                            </div>
                            <form method="POST" action="{{ route('CheckPayStatus') }}">
                                  {{ csrf_field() }}
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

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" name="matricno" class="form-control form-control" id="exampleFirstName"
                                            placeholder="Matriculation Number" required="true">
                                    </div>
                                     <button class="btn px-4" type="submit" style="background:#c0a062;color:#FFF">Check </button>
                             
                                </div>
                               
                             
                               
                            <hr>
                                                    </div>
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