<?php include('db_connect.php');?>
<?php
function generateRow($conn,$secid,$semester){
        $content='';

        if(isset($secid) and isset($semester)){
            $i = 1;
            $loads = $conn->query("SELECT * FROM loading where course='$secid' and semester='$semester' order by timeslot_sid asc");
            while($lrow=$loads->fetch_assoc()){
                $days = $lrow['days'];
                $timeslot = $lrow['timeslot'];
                $course = $lrow['course'];
                $subject_code = $lrow['subjects'];
                $room_id = $lrow['rooms'];
                $instid = $lrow['faculty'];
            

                $subjects = $conn->query("SELECT * FROM subjects WHERE subject = '$subject_code'");
            while($srow=$subjects->fetch_assoc()){
                $description = $srow['description'];
                $units = $srow['total_units'];
            }

            $faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from faculty WHERE id=".$instid);
            while($frow=$faculty->fetch_assoc()){
                $instname = $frow['name'];
            }

            $rooms = $conn->query("SELECT * FROM roomlist WHERE room_id = ".$room_id);
            while($roomrow=$rooms->fetch_assoc()){
                $room_name = $roomrow['room_name'];
            }

           

            $content .='<tr>
                <td width="100px" align="center">'.$timeslot.'</td>
                <td width="40px" align="center">'.$days.'</td>
                <td align="center">'.$subject_code.'</td>
                <td width="130px" align="center">'.$description.'</td>
                <td width="40px" align="center">'.$units.'</td>
                <td align="center">'.$room_name.'</td>
                <td align="center">'.$instname.'</td>
            </tr>';
        }

        }else{
                $i = 1;
                $loads = $conn->query("SELECT * FROM loading order by timeslot_sid asc");
                while($lrow=$loads->fetch_assoc()){
                    $days = $lrow['days'];
                    $timeslot = $lrow['timeslot'];
                    $course = $lrow['course'];
                    $subject_code = $lrow['subjects'];
                    $room_id = $lrow['rooms'];
                    $instid = $lrow['faculty'];

                    $subjects = $conn->query("SELECT * FROM subjects WHERE subject = '$subject_code'");
                while($srow=$subjects->fetch_assoc()){
                    $description = $srow['description'];
                    $units = $srow['total_units'];
                }

                $faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from faculty WHERE id=".$instid);
                while($frow=$faculty->fetch_assoc()){
                    $instname = $frow['name'];
                }

                $rooms = $conn->query("SELECT * FROM roomlist WHERE room_id = ".$room_id);
                while($roomrow=$rooms->fetch_assoc()){
                    $room_name = $roomrow['room_name'];
                }

                $content .='<tr>
                <td align="center">'.$timeslot.'</td>
                <td width="40px" align="center">'.$days.'</td>
                <td align="center">'.$subject_code.'</td>
                <td width="130px" align="center">'.$description.'</td>
                <td width="40px" align="center">'.$units.'</td>
                <td align="center">'.$room_name.'</td>
                <td align="center">'.$instname.'</td>
            </tr>';
            }
        }
    
        $content .='</tbody>';

                    return $content;
}
$secid =$_GET['secid'];
$semester =$_GET['semester'];
$rooms = $conn->query("SELECT DISTINCT room_name FROM roomlist;");
while($roomrow=$rooms->fetch_assoc()){
    $room = $roomrow['room_name'];
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
    $content .= '<h2 align="left">Class schedule of '.$secid.' | '.$semester.'</h2>
    <table border="0.5" cellspacing="0" cellpadding="3">
    <thead>
        <tr>
            <th width="100px" align="center">Time</th>
            <th width="40px" align="center">Days</th>
            <th align="center">Course code</th>
            <th width="130px" align="center">Description</th>
            <th width="40px" align="center">Units</th>
            <th align="center">Room</th>
            <th align="center">Instructor</th>
        </tr>
    </thead>
    <tbody>
      ';
    $content .= generateRow($conn,$secid,$semester);
    $content .= '</table>';
    $pdf->writeHTML($content);
    $pdf->Output('roomassign.pdf', 'I');
?>