 <!DOCTYPE html>
 <html>
 <head>
     <title> </title>
 </head>
 <body>
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

<?php
   use lluminate\Support\Collection;
   $mat ="040508";
   $data = DB::SELECT('CALL GetTranscriptByMatricNo(?)', array($mat));    
   // dd($data);
   $model = collect($data);
//dd($model);
?>
     <div class="row">
             <div class="col-4">
             </div>
             <div class="col-6">
                <div align="center"><img src="dashboard/img/logo.png" style="max-width:100%;height:auto;"/>
               </div>
             </div>
 </div>
  <div style="overflow-x:auto; ">
                <div align="center">
                  <table width="698" border="0" align="center">
                    <thead>
                      <tr>
                        <td width="39" rowspan="9" class="noBorder" >&nbsp;</td>
                      <td width="164" class="noBorder" ><div align="right">Student Name</div></td>
                      <td width="481" class="noBorder1"><div align="left">{{  $data[0]->surname}} {{  $data[0]->othernames}}</div></td>
                   </tr>
                      <tr>
                        <td class="noBorder"><div align="right">MatricNo</div></td>
                      <td class="noBorder1"><div align="left">{{ $data[0]->matricno}}</div></td>
                   </tr>
                      <tr>
                        <td class="noBorder"><div align="right">Faculty</div></td>
                      <td class="noBorder1"><div align="left">{{ $data[0]->Faculty }}</div></td>
                   </tr>
                      <tr>
                        <td class="noBorder"><div align="right">Department</div></td>
                      <td class="noBorder1"><div align="left">{{ $data[0]->Department }}</div></td>
                   </tr>
                    </thead>
                              </table>
                </div>
 </div>


  <div align="center">
    <?php
 if($model)
  {
        $tcu = 0;
        $tcp = 0;
        $count = 0;

        $grp = $model->groupBy('level');
       
           foreach ($grp as $level)
           {
             $sn = 1;
             $sn2 = 1;

               if ($level->where('semester',1)->count() > 0)
               {
                  $count++;
                  $tcu = $tcu + $level->where('semester',1)->sum('courseunit');
                  $tcp = $tcp + $level->where('semester',1)->sum('CoursePoint');
                 
                 //dd($level[0]->level);
          echo '<br/>'; echo '<br/>';
            echo '<table class="table table-condensed" align="center">
                    <tr>';
                        echo '<th>'.  $level[0]->level . ' Level First Semester '.$level[0]->AcademicName .' Session'.

                        '</th>';
    
                   echo '</tr>
                </table>';



                echo "<table class='table table-condensed table-bordered' align='center'>";
                echo '<tr>';
                echo '<th>SN</th>';
                echo '<th>Course Code</th>';
                echo '<th>Course Title</th>';
                echo '<th>Score</th>';
                echo '<th>Grade</th>';
                echo '<th>Course Unit</th>';
                echo '<th>Course Point</th>';
                echo '</tr>';
                //echo($level);
                    foreach ($level as $item)
                    {

                        
                        if ($item->semester == 1)
                         {
                             echo '<tr>';
                             echo '<td>'.$sn.'</td>';
                             echo '<td>'.$item->coursecode.'</td>';
                             echo '<td>'.$item->coursetitle.'</td>';
                             echo '<td>'.$item->Score.'</td>';
                             echo '<td>'.$item->Grade.'</td>';
                             echo '<td>'.$item->courseunit.'</td>';
                             echo '<td>'.$item->CoursePoint.'</td>';
                             echo '</tr>';
                            $sn++;

                        }

                    }

                        echo '<tr>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th>'.$level->where('semester',1)->sum('courseunit').'</th>';
                        echo '<th>'.$level->where('semester',1)->sum('CoursePoint').'</th>';
                        echo '</tr>';
                        echo '</table>';

                $PGPA = 0;
                if ($count <= 1)
                {
                    
                }
                else
                {
                 $PGPA = ($tcp - $level->where('semester',1)->sum('CoursePoint')) / ($tcu - $level->where('semester', 1)->sum('courseunit'));
                }
                $A=$level->where('semester', 1)->sum('CoursePoint');
                $B = $level->where('semester',1)->sum('courseunit');
               
                $GPA = $A / $B;
                $CGPA = $tcp / $tcu;

                echo '<table class="table table-condensed table-bordered text-left" align="center">';
                echo '<tr>';
                echo '<th>Previous GPA ='. round($PGPA,2).'</th>';
                echo '<th>Current GPA ='.round($GPA,2).'</th>';
                echo '<th>Cummulative GPA ='. round($CGPA,2).'</th>';
                echo '</tr>';
                echo '</table>';
              }

              echo '<br/>';
                if ($level->where('semester',2))
                {
                  $count++;
                  $tcu = $tcu + $level->where('semester',2)->sum('courseunit');
                  $tcp = $tcp + $level->where('semester',2)->sum('CoursePoint');
 echo '<br/>';
                   echo '<table class="table table-condensed" align="center">
                    <tr>';
                        echo '<th>'.  $level[0]->level . ' Level Second Semester '.$level[0]->AcademicName .' Session'.

                        '</th>';
    
                   echo '</tr>
                </table>';

                       echo "<table class='table table-condensed table-bordered' align='center'>";
                    echo '<tr>
                        <th>SN</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Score</th>
                        <th>Grade</th>
                        <th>Course Unit</th>
                        <th>Course Point</th>
                    </tr>';

                    foreach ($level as $item)
                    {
                        $count++;

                        if ($item->semester == 2)
                        {
                             echo '<tr>';
                             echo '<td>'.$sn2.'</td>';
                             echo '<td>'.$item->coursecode. '</td>';
                             echo '<td>'.$item->coursetitle.'</td>';
                             echo '<td>'.$item->Score.'</td>';
                             echo '<td>'.$item->Grade.'</td>';
                             echo '<td>'.$item->courseunit.'</td>';
                             echo '<td>'.$item->CoursePoint.'</td>';
                             echo '</tr>';
                            echo '</tr>';
                            $sn2++;
                        }

                    }

                    echo '<tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        ';
                        echo '<th>'.$level->where('semester',2)->sum('courseunit') .'</th>';
                        echo '<th>'.$level->where('semester',2)->sum('CoursePoint').'</th>';
                    echo '</tr>';
                    echo '</table>';

                $PGPA = ($tcp - $level->where('semester',2)->sum('CoursePoint')) / ($tcu - $level->where('semester',2)->sum('courseunit'));
                $GPA = ($level->where('semester',2)->sum('CoursePoint')) / ($level->where('semester',2)->sum('courseunit'));
                $CGPA = $tcp / $tcu;

                echo '<table class="table table-condensed table-bordered text-left" align="center">
                    <tr>';
                        echo '<th>Previous GPA ='.round($PGPA,2).'</th>';
                        echo '<th>Current GPA ='.  round($GPA,2) .'</th>';
                        echo '<th>Cummulative GPA ='.round($CGPA,2).'</th>';
                   echo '</tr>
                </table>';
              
              }
           }

  }
?>
   </div>
 </body>
 </html>
 