<?php include('db_connect.php');?>
<?php
function generateRow($conn){
        $content='';

        $sumloads=0;
        $sumotherl=0;
        $sumoverl=0;
        $totalloads=0;

        $sumloads=0;
        $sumotherl=0;
        $sumoverl=0;
        $totalloads=0;
        $instname = '';


            $loads = $conn->query("SELECT `faculty`, GROUP_CONCAT(DISTINCT `sub_description` ORDER BY `sub_description` ASC SEPARATOR ', ') AS `subject`, SUM(`total_units`) AS `totunits` FROM `loading` GROUP BY `faculty`");
        while($lrow=$loads->fetch_assoc()){
            $subjects = $lrow['subject'];
            $faculty_id = $lrow['faculty'];
            $sumloads = $lrow['totunits'];
            $totalloads = $sumloads + $sumotherl;
            
            $faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty WHERE id='$faculty_id' order by concat(lastname,', ',firstname,' ',middlename) asc");
            while($frow=$faculty->fetch_assoc()){
                $instname = $frow['name'];
            
            }

        $content .='<tr>
                    <td width="150px" align="center">'.$instname.'</td>
                    <td width="200px" align="center">'.$subjects.'</td>
                    <td width="40px" align="center">'.$sumloads.'</td>
                    <td width="40px" align="center">'.$sumotherl.'</td>
                    <td width="40px" align="center">'.$sumoverl.'</td>
                    <td width="40px" align="center">'.$totalloads.'</td>
                </tr>';
        }
    
        $content .='</tbody>';

                    return $content;
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
    $content .= '<h2 align="left">Summary of Teaching Loads</h2>
    <table border="0.5" cellspacing="0" cellpadding="3">
        <thead>
        <tr>
            <th width="150px" align="center">Name of Instructors</th>
            <th width="200px" align="center">Subjects/Course</th>
            <th width="40px" align="center">Load</th>
            <th width="40px" align="center">Other Load</th>
            <th width="40px" align="center">Overload</th>
            <th width="40px" align="center">Total</th>
        </tr>
    </thead>
    <tbody>
      ';
    $content .= generateRow($conn);
    $content .= '</table>';
    $pdf->writeHTML($content);
    $pdf->Output('roomassign.pdf', 'I');
?>