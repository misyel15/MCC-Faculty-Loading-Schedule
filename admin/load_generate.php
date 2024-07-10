<?php include('db_connect.php');?>
<?php
function generateRow($conn,$id){
        $content='';

        if(isset($id)){
            $i = 1;
            $sumtu=0;
            $sumh=0;
            $loads = $conn->query("SELECT * FROM loading where faculty='$id' order by timeslot_sid asc");
            while($lrow=$loads->fetch_assoc()){
                $days = $lrow['days'];
                $timeslot = $lrow['timeslot'];
                $course = $lrow['course'];
                $subject_code = $lrow['subjects'];
                $room_id = $lrow['rooms'];
                $fid = $lrow['faculty'];
                //$hours = $lrow['hours'];
                //$sumh += $hours;
    
                $faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from faculty Where id =".$fid);
            while($frow=$faculty->fetch_assoc()){
                $instname = $frow['name'];
            }
                        
            $subjects = $conn->query("SELECT * FROM subjects WHERE subject = '$subject_code'");

            while($srow=$subjects->fetch_assoc()){
                $description = $srow['description'];
                $units = $srow['total_units'];
                $lec_units = $srow['Lec_Units'];
                $lab_units = $srow['Lab_Units'];
                $hours = $srow['hours'];
                $sumh += $hours;
                $sumtu += $units;
                    
            }
            

            $rooms = $conn->query("SELECT * FROM roomlist WHERE id = ".$room_id);
            while($roomrow=$rooms->fetch_assoc()){
                $room_name = $roomrow['room_name'];
            }

            $content .='<tr>
                <td width="50px" align="center">'.$subject_code.'</td>
                <td width="100px" align="center">'.$description.'</td>
                <td width="50px" align="center">'.$days.'</td>
                <td width="50px" align="center">'.$timeslot.'</td>
                <td width="50px" align="center">'.$course.'</td>
                <td width="80px" align="center">'.$lec_units.'</td>
                <td width="50px" align="center">'.$lab_units.'</td>
                <td width="50px" align="center">'.$units.'</td>
                <td width="50px" align="center">'.$hours.'</td>
            </tr>';
        }
        $content .='<tr style="height: 20px">
                <td class="s4"></td>
                <td class="s3"></td>
                <td class="s3"></td>
                <td class="s3"></td>
                <td class="s3"></td>
                <td class="s10 softmerge">
                    <div class="softmerge-inner" style="width:298px;left:-1px">
                        <span style="font-weight:bold; font-size:10px;" >               Total Number of Units/Hours(Basic)</span>
                    </div>
                </td>
                <td class="s11"></td>
                <td class="text-center" align="center">'.$sumtu.'</td>
                <td class="text-center" align="center">'.$sumh.'</td>
            </tr>';

    }else{
        $sumtu=0;
            $sumh=0;
        $i = 1;
        $loads = $conn->query("SELECT * FROM loading order by timeslot_sid asc");
        while($lrow=$loads->fetch_assoc()){
            $days = $lrow['days'];
            $timeslot = $lrow['timeslot'];
            $course = $lrow['course'];
            $subject_code = $lrow['subjects'];
            $room_id = $lrow['rooms'];
            $fid = $lrow['faculty'];
            //$hours = $lrow['hours'];
            // $sumh += $hours;
            
            $faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from faculty Where id =".$fid);
            while($frow=$faculty->fetch_assoc()){
                $instname = $frow['name'];
            }

            $subjects = $conn->query("SELECT * FROM subjects WHERE subject = '$subject_code'");
        while($srow=$subjects->fetch_assoc()){
            $description = $srow['description'];
            $units = $srow['total_units'];
            $lec_units = $srow['Lec_Units'];
            $lab_units = $srow['Lab_Units'];
            $hours = $srow['hours'];
            $sumh += $hours;
            $sumtu += $units;
	
        }

        $rooms = $conn->query("SELECT * FROM roomlist WHERE id = ".$room_id);
        while($roomrow=$rooms->fetch_assoc()){
            $room_name = $roomrow['room_name'];
        }

        $content .='<tr>
            <td width="100px" align="center">'.$subject_code.'</td>
            <td width="100px" align="center">'.$description.'</td>
            <td width="100px" align="center">'.$days.'</td>
            <td width="100px" align="center">'.$timeslot.'</td>
            <td width="100px" align="center">'.$course.'</td>
            <td width="100px" align="center">'.$lec_units.'</td>
            <td width="100px" align="center">'.$lab_units.'</td>
            <td width="100px" align="center">'.$units.'</td>
            <td width="100px" align="center">'.$hours.'</td>
        </tr>';
            
        }
        $content .='<tr style="height: 20px">
            <td class="s4"></td>
            <td class="s3"></td>
            <td class="s3"></td>
            <td class="s3"></td>
            <td class="s3"></td>
            <td class="s10 softmerge">
                <div class="softmerge-inner" style="width:298px;left:-1px">
                    <span style="font-weight:bold; font-size:10px;">               Total Number of Units/Hours(Basic)</span>
                </div>
            </td>
            <td class="s11"></td> 
            <td class="text-center" align="center">'.$sumtu.'</td>
            <td class="text-center" align="center">'.$sumh.'</td>
        </tr>';
    }
    
        $content .='</tbody>';

                    return $content;
}
$id =$_GET['id'];
$faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from faculty Where id =".$id);
        while($frow=$faculty->fetch_assoc()){
            $instname = $frow['name'];
        }

require_once('../tcpdf/tcpdf.php');
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Room Assignment');
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 11);
    $pdf->AddPage();
    $content = '';
    $content .= '<h2 align="left">Instructors Load of '.$instname.'</h2>
    <table border="0.5" cellspacing="0" cellpadding="3">
    <thead>
        <tr>
            <th width="50px" align="center">Code</th>
            <th width="100px" align="center">Descriptive Title</th>
            <th width="50px" align="center">Day</th>
            <th width="50px" align="center">Time</th>
            <th width="50px" align="center">Section</th>
            <th width="80px" align="center">Units (lec)</th>
            <th width="50px" align="center">Units (lab)</th>
            <th width="50px" align="center">Total Units</th>
            <th width="50px" align="center">Total Hours</th>
        </tr>
    </thead>
    <tbody>
      ';
    $content .= generateRow($conn,$id);
    $content .= '</table>';
    $pdf->writeHTML($content);
    $pdf->Output('roomassign.pdf', 'I');
?>