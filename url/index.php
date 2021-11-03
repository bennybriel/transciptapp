<?php
      @$id = $_GET['response'];
      //echo $id;
      $port ="3606";
      $con = mysqli_connect("localhost","lautechp_apply","applyadmin","lautechp_transcript",$port);
	// Check connection
	   if ($con -> connect_errno) {
	    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	    exit();
	  }
	
	
          
               $txnref      = $_POST['txnref'];
               $status      = $_POST['status'];
              // echo $status;
             
          
          //Check Returning URL
            //$url = "https://gatewaylautech.bennybriel.com/index.php/api/getPaymentStatus/".$_POST['txnref'];    
            //$response =$client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
            //$res = json_decode($response->getBody());
            //$sq = "INSERT INTO request_loggers (request) VALUES ('".json_encode($res)."')"; $con->query($sq);



            //dd($res);
       // if($res)
       // {
            $res =$status . ' '.$_POST['txnref'];
            $sq = "INSERT INTO request_loggers (request) VALUES ('".$res."')"; $con->query($sq);
            if($status == "Transaction Successful")
            {
                 
                $sta = 1;
                $resp       = $res->status;
                $yr= date("Y");
        
              $sql = "UPDATE u_g_student_accounts 
              SET ispaid = 1, st.response ='". $status."'
              WHERE transactionID ='". $txnref."'";
              $res = $con->query($sql);

                    if($res > 0)
                      {
                          $script = "<script>
                                      window.location = 'DataInfo';
                                  </script>";
                          echo $script;
                      }
                      else
                      {
                          // $res =$status . ' '.$_POST['txnref'];
                            //$sq = "INSERT INTO request_loggers (request) VALUES ('".$res."')"; $con->query($sq);
                            $script = "<script>
                                  window.location = 'home';
                                </script>";
                              echo $script;
                      }
            }     
         
?>   
      
    

