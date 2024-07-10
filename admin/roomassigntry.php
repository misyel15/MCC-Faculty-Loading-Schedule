<?php include('db_connect.php');?>

<div class="container-fluid">
			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<center><h3>Monday/Wednesday</h3></center>
					
						<style>
    .btn-margin {
        margin-right: 5px; /* Adjust this value as needed */
    }
</style>

<div class="dropdown btn-margin">
    <button class="btn btn-danger btn-sm col-sm-1 float-right dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	<i class="fa fa-trash-alt"></i>   Delete Table
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item delete_MW" data-day="MW">Monday/Wednesday</a>
        <a class="dropdown-item delete_TTh" data-day="TTH">Tuesday/Thursday</a>
        <a class="dropdown-item delete_Fri" data-day="FS">Friday/Saturday</a>
        <!--<a class="dropdown-item delete_Sat" data-day="Sat">Saturday</a>-->
    </div>
</div>

<button type="button" class="btn btn-success float-right btn-sm btn-flat btn-margin" id="print">
    <span class="glyphicon glyphicon-print"></span><i class="fa fa-print"></i> Print
</button>

<button class="btn btn-primary btn-block btn-sm col-sm-1 float-right btn-margin" id="new_schedule_mw">
    <i class="fa fa-user-plus"></i> New Entry
</button>


					
				<form method="POST" class="form-inline" id="printra" action="roomassign_generate.php" style="margin-left: 575px;">
							</form>
						
                        </div>
					<div class="card-body">
					<table class="table table-bordered waffle no-grid" id="insloadtable">
					<thead>
						<tr>
							<th class="text-center">Time</th>
					<?php
						$finaltbl = '';
					// $rooms = $conn->query("SELECT DISTINCT room_name FROM roomlist order by id;");
					$rooms = array();
					$roomsdata = $conn->query("SELECT * FROM roomlist order by room_id;");
					while($r=$roomsdata->fetch_assoc()){
					$room = $r['room_name'];
					$rooms[] = $r['room_name'];
					}
					$times = array();
					$timesdata = $conn->query("SELECT * FROM timeslot Where schedule='MW' order by time_id;");
					while($t=$timesdata->fetch_assoc()){
					$timeslot = $t['timeslot'];
					$times[] = $t['timeslot'];
					// print_r($times);
					}

					// // Define time and room variables
					// $times = array("9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM", "5:00 PM");
					// $rooms = array("Room 1", "Room 2", "Room 3", "Room 4");

					// Create table header
					// echo '<table class="table table-bordered waffle no-grid" id="insloadtable">';
					// echo '<thead><tr><th class="text-center">Time</th>';
					foreach ($rooms as $room) {
						$finaltbl .= '<th class="text-center">'.$room.'</th>';
					}
					$finaltbl .= "</tr></thead>";

					// Create table body
					$finaltbl .= "<tbody>";
					foreach ($times as $time) {
						$finaltbl .= "<tr><td>$time</td>";
					foreach ($rooms as $room) {
					// Query database for events in this time and room
					$query = "SELECT * FROM loading WHERE timeslot='$time' AND room_name='$room' AND days ='MW'";
					$result = mysqli_query($conn, $query);
					if (mysqli_num_rows($result) > 0) {
					// Display event information
					$row = mysqli_fetch_assoc($result);
					$course = $row['course'];
					$subject = $row['subjects'];
					$faculty = $row['faculty'];
					$load_id = $row['id'];
					$scheds = $subject." ".$course;
					$faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty Where id=".$faculty);
					foreach ($faculty as $frow) {
					$instname = $frow['name'];
					$newSched= $scheds." ".$instname;
					}
					$finaltbl .= '<td class="s9 text-center content" data-id = "'.$load_id.'" data-scode="'.$subject.'" dir="ltr">'.$newSched.'<br><span><button class="btn btn-sm btn-primary edit_load" type="button" data-id="'.$load_id.'"><i class="fa fa-edit"></i> Edit</button></span>  <span><button class="btn btn-sm btn-danger delete_load" type="button" data-id="'.$load_id.'" data-scode="'.$subject.'"><i class="fa fa-trash-alt"></i> Delete</button></span></td>';
					} else {
					// Display empty cell
					$finaltbl .= "<td></td>";
					}
					}
					$finaltbl .= "</tr>";
					}
					$finaltbl .= "</tbody>";
					$finaltbl .= "</table>";

					echo $finaltbl;
					?>
					</div>
				</div>
			</div><br>
		</div>
	</div>
	<div class="container-fluid">
							<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<center><h3>Tuesday/Thursday</h3></center>
						<span class="float:right">
				<form method="POST" class="form-inline" id="printratth" action="roomassign_generatetth.php" style="margin-left: 575px;">
						</form></span>
						<button type="button" class="btn btn-success btn-sm btn-flat float-right" id="printtth"><span class="glyphicon glyphicon-print"></span><i class="fa fa-print"></i> Print</button>
					
                        </div>
					<div class="card-body">
					<table class="table table-bordered waffle no-grid" id="insloadtable">
					<thead>
						<tr>
							<th class="text-center">Time</th>
					<?php
					$finaltbl = '';
					// $rooms = $conn->query("SELECT DISTINCT room_name FROM roomlist order by id;");
					$rooms = array();
					$roomsdata = $conn->query("SELECT * FROM roomlist order by room_id;");
					while($r=$roomsdata->fetch_assoc()){
					$room = $r['room_name'];
					$rooms[] = $r['room_name'];
					}
					$times = array();
					$timesdata = $conn->query("SELECT * FROM timeslot Where schedule='TTH' order by time_id;");
					while($t=$timesdata->fetch_assoc()){
					$timeslot = $t['timeslot'];
					$times[] = $t['timeslot'];
					// print_r($times);
					}

					// // Define time and room variables
					// $times = array("9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM", "5:00 PM");
					// $rooms = array("Room 1", "Room 2", "Room 3", "Room 4");

					// Create table header
					// echo '<table class="table table-bordered waffle no-grid" id="insloadtable">';
					// echo '<thead><tr><th class="text-center">Time</th>';
					foreach ($rooms as $room) {
						$finaltbl .= '<th class="text-center">'.$room.'</th>';
					}
					$finaltbl .= "</tr></thead>";

					// Create table body
					$finaltbl .= "<tbody>";
					foreach ($times as $time) {
						$finaltbl .= "<tr><td>$time</td>";
					foreach ($rooms as $room) {
					// Query database for events in this time and room
					$query = "SELECT * FROM loading WHERE timeslot='$time' AND room_name='$room' AND days ='TTH'";
					$result = mysqli_query($conn, $query);
					if (mysqli_num_rows($result) > 0) {
					// Display event information
					$row = mysqli_fetch_assoc($result);
					$course = $row['course'];
					$subject = $row['subjects'];
					$faculty = $row['faculty'];
					$load_id = $row['id'];
					$scheds = $subject." ".$course;
					$faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty Where id=".$faculty);
					foreach ($faculty as $frow) {
					$instname = $frow['name'];
					$newSched= $scheds." ".$instname;
					}
					$finaltbl .= '<td class="s9 text-center content" data-id = "'.$load_id.'" data-scode="'.$subject.'" dir="ltr">'.$newSched.'<br><span><button class="btn btn-sm btn-primary edit_load" type="button" data-id="'.$load_id.'"><i class="fa fa-edit"></i> Edit</button></span>  <span><button class="btn btn-sm btn-danger delete_load" type="button" data-id="'.$load_id.'" data-scode="'.$subject.'"><i class="fa fa-trash-alt"></i> Delete</button></span></td>';
					} else {
					// Display empty cell
					$finaltbl .= "<td></td>";
					}
					}
					$finaltbl .= "</tr>";
					}
					$finaltbl .= "</tbody>";
					$finaltbl .= "</table>";

					echo $finaltbl;
					?>
					</div>
				</div>
			</div><br>
		</div>
	</div>
	<div class="container-fluid">
							<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<center><h3>Friday/Saturday</h3></center>
						<span class="float:right">
				<form method="POST" class="form-inline" id="printrafri" action="roomassign_generatefri.php" style="margin-left: 575px;">
						</form></span>
						<button type="button" class="btn btn-success btn-sm btn-flat float-right" id="printfri"><span class="glyphicon glyphicon-print"></span><i class="fa fa-print"></i> Print</button>
						
                        </div>
					<div class="card-body">
					<table class="table table-bordered waffle no-grid" id="insloadtable">
					<thead>
						<tr>
							<th class="text-center">Time</th>
					<?php
					$finaltbl = '';
					// $rooms = $conn->query("SELECT DISTINCT room_name FROM roomlist order by id;");
					$rooms = array();
					$roomsdata = $conn->query("SELECT * FROM roomlist order by room_id;");
					while($r=$roomsdata->fetch_assoc()){
					$room = $r['room_name'];
					$rooms[] = $r['room_name'];
					}
					$times = array();
					$timesdata = $conn->query("SELECT * FROM timeslot Where schedule='Fs' order by time_id;");
					while($t=$timesdata->fetch_assoc()){
					$timeslot = $t['timeslot'];
					$times[] = $t['timeslot'];
					// print_r($times);
					}

					// // Define time and room variables
					// $times = array("9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM", "5:00 PM");
					// $rooms = array("Room 1", "Room 2", "Room 3", "Room 4");

					// Create table header
					// echo '<table class="table table-bordered waffle no-grid" id="insloadtable">';
					// echo '<thead><tr><th class="text-center">Time</th>';
					foreach ($rooms as $room) {
						$finaltbl .= '<th class="text-center">'.$room.'</th>';
					}
					$finaltbl .= "</tr></thead>";

					// Create table body
					$finaltbl .= "<tbody>";
					foreach ($times as $time) {
						$finaltbl .= "<tr><td>$time</td>";
					foreach ($rooms as $room) {
					// Query database for events in this time and room
					$query = "SELECT * FROM loading WHERE timeslot='$time' AND room_name='$room' AND days ='FS'";
					$result = mysqli_query($conn, $query);
					if (mysqli_num_rows($result) > 0) {
					// Display event information
					$row = mysqli_fetch_assoc($result);
					$course = $row['course'];
					$subject = $row['subjects'];
					$faculty = $row['faculty'];
					$load_id = $row['id'];
					$scheds = $subject." ".$course;
					$faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty Where id=".$faculty);
					foreach ($faculty as $frow) {
					$instname = $frow['name'];
					$newSched= $scheds." ".$instname;
					}
					$finaltbl .= '<td class="s9 text-center content" data-id = "'.$load_id.'" data-scode="'.$subject.'" dir="ltr">'.$newSched.'<br><span><button class="btn btn-sm btn-primary edit_load" type="button" data-id="'.$load_id.'"><i class="fa fa-edit"></i> Edit</button></span>  <span><button class="btn btn-sm btn-danger delete_load" type="button" data-id="'.$load_id.'" data-scode="'.$subject.'"><i class="fa fa-trash-alt"></i> Delete</button></span></td>';
					} else {
					// Display empty cell
					$finaltbl .= "<td></td>";
					}
					}
					$finaltbl .= "</tr>";
					}
					$finaltbl .= "</tbody>";
					$finaltbl .= "</table>";

					echo $finaltbl;
					?>
					</div>
				</div>
			</div><br>
		</div>
	</div>
	<div class="container-fluid">
							<!-- Table Panel -->
				<!--<div class="col-md-12">
				<div class="card">
					<div class="card-header">
					<center><h3>Saturday</h3></center>
						<span class="float:right">
				<form method="POST" class="form-inline" id="printrasat" action="roomassign_generatesat.php" style="margin-left: 575px;">
						<button type="button" class="btn btn-success btn-sm btn-flat" id="printsat"><span class="glyphicon glyphicon-print"></span> Print</button>
						</form></span>
						
                        </div>
					<div class="card-body">
					<table class="table table-bordered waffle no-grid" id="insloadtable">
					<thead>
						<tr>
							<th class="text-center">Time</th>-->
					<?php
					//$finaltbl = '';
					// $rooms = $conn->query("SELECT DISTINCT room_name FROM roomlist order by id;");
					//$rooms = array();
					//$roomsdata = $conn->query("SELECT * FROM roomlist order by room_id;");
					//while($r=$roomsdata->fetch_assoc()){
					//$room = $r['room_name'];
					//$rooms[] = $r['room_name'];
					//}
					//$times = array();
					//$timesdata = $conn->query("SELECT * FROM timeslot Where schedule='Sat' order by time_id;");
					//while($t=$timesdata->fetch_assoc()){
					//$timeslot = $t['timeslot'];
					//$times[] = $t['timeslot'];
					// print_r($times);
					//}

					// // Define time and room variables
					// $times = array("9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM", "5:00 PM");
					// $rooms = array("Room 1", "Room 2", "Room 3", "Room 4");

					// Create table header
					// echo '<table class="table table-bordered waffle no-grid" id="insloadtable">';
					// echo '<thead><tr><th class="text-center">Time</th>';
					//foreach ($rooms as $room) {
					//	$finaltbl .= '<th class="text-center">'.$room.'</th>';
					//}
					//$finaltbl .= "</tr></thead>";

					// Create table body
					//$finaltbl .= "<tbody>";
					//foreach ($times as $time) {
					//	$finaltbl .= "<tr><td>$time</td>";
					//foreach ($rooms as $room) {
					// Query database for events in this time and room
					//$query = "SELECT * FROM loading WHERE timeslot='$time' AND room_name='$room' AND days ='Sat'";
					//$result = mysqli_query($conn, $query);
					//if (mysqli_num_rows($result) > 0) {
					// Display event information
					//$row = mysqli_fetch_assoc($result);
					//$course = $row['course'];
					//$subject = $row['subjects'];
					//$faculty = $row['faculty'];
					//$load_id = $row['id'];
					//$scheds = $subject." ".$course;
					//$faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty Where id=".$faculty);
					//foreach ($faculty as $frow) {
					//$instname = $frow['name'];
					//$newSched= $scheds." ".$instname;
					//}
					//$finaltbl .= '<td class="s9 text-center content" data-id = "'.$load_id.'" data-scode="'.$subject.'" dir="ltr">'.$newSched.'<br><span><button class="btn btn-sm btn-primary edit_load" type="button" data-id="'.$load_id.'">Edit</button></span>  <span><button class="btn btn-sm btn-danger delete_load" type="button" data-id="'.$load_id.'" data-scode="'.$subject.'">Delete</button></span></td>';
					//} else {
					// Display empty cell
					//$finaltbl .= "<td></td>";
					//}
					//}
					//$finaltbl .= "</tr>";
					//}
					//$finaltbl .= "</tbody>";
					//$finaltbl .= "</table>";

					//echo $finaltbl;
					?>
					</div>
				</div>
			</div><br>
		</div>
	</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">User Details</h4>
    </div>
    <div class="modal-body">
      <div class="scheddays"><p>Schedule: </p><span></span></div>
      <div class="time"><p>Time: </p><span></span></div>
      <div class="course"><p>Course Code: </p><span></span></div>
      <div class="description"><p>Description: </p><span></span></div>
      <div class="units"><p>Units: </p><span></span></div>
      <div class="room"><p>Room: </p><span></span></div>
	  <div class="instructor"><p>Instructor: </p><span></span></div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    </div>
  </div>
  
</div>
</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 $(document).ready(function () {
    $(document).on('mouseenter', 'div', function () {
        $(this).find(".edit_load").show();
		$(this).find(".delete_load").show();
    }).on('mouseleave', 'div', function () {
        $(this).find(".edit_load").hide();
		$(this).find(".delete_load").hide();
    });
	$('.dropdown-toggle').dropdown();
});
$('.delete_load').click(function(){
    confirmDeletion("Are you sure you want to delete this room?", "delete_load", $(this).attr('data-id'));
});

$('.delete_MW').click(function(){
    confirmDeletion("Are you sure you want to delete this room?", "delete_MW", $(this).attr('data-day'));
});

$('.delete_TTh').click(function(){
    confirmDeletion("Are you sure you want to delete this room?", "delete_TTh", $(this).attr('data-day'));
});

$('.delete_Fri').click(function(){
    confirmDeletion("Are you sure you want to delete this room?", "delete_Fri", $(this).attr('data-day'));
});

$('.delete_Sat').click(function(){
    confirmDeletion("Are you sure you want to delete this room?", "delete_Sat", $(this).attr('data-day'));
});

function confirmDeletion(message, action, data) {
    Swal.fire({
        title: 'Confirm Deletion',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteData(action, data);
        }
    });
}

function deleteData(action, data) {
    $.ajax({
        url: 'ajax.php?action=' + action,
        method: 'POST',
        data: { id: data }, // Adjust this if `data` is `days` for other actions
        success: function(resp) {
            if (resp == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Data successfully deleted.',
                    showConfirmButton: true,
                }).then(() => {
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred'
                });
            }
        }
    });
}

	/*$("td").hover(function(){
$(this).css( "background-color", "red" );
}, function(){
$(this).css( "background-color", "white" );
});*/
$('.edit_load').click(function(){
	uni_modal('Edit Load','manage_room.php?id='+$(this).attr('data-id'))
})
$('.edit_loadtth').click(function(){
	uni_modal('Edit Load','manage_roomtth.php?id='+$(this).attr('data-id'))
})

$('#new_schedule_mw').click(function(){
		uni_modal('New Schedule','manage_room.php','mid-small')
	})

	$('#new_schedule_tth').click(function(){
		uni_modal('New Schedule','manage_room.php','mid-small')
	})

	$('#new_schedule_f').click(function(){
		uni_modal('New Schedule','manage_room.php','mid-small')
	})

	$('#print').click(function(e){
    e.preventDefault();
    $('#printra').attr('action', 'roomassign_generate.php');
    $('#printra').submit();
  });
  $('#printtth').click(function(e){
    e.preventDefault();
    $('#printratth').attr('action', 'roomassign_generatetth.php');
    $('#printratth').submit();
  });
  $('#printfri').click(function(e){
    e.preventDefault();
    $('#printrafri').attr('action', 'roomassign_generatefri.php');
    $('#printrafri').submit();
  });
  $('#printsat').click(function(e){
    e.preventDefault();
    $('#printrasat').attr('action', 'roomassign_generatesat.php');
    $('#printrasat').submit();
  });

  /*$(function() {
    var tableRows = $("#insloadtable tbody tr"); //find all the rows
    var rowValues = []; //to keep track of which values appear more than once
    tableRows.each(function() { 
        var rowValue = $(this).find(".content").html();
        if (!rowValues[rowValue]) {
            var rowComposite = new Object();
            rowComposite.count = 1;
            rowComposite.row = this;
            rowValues[rowValue] = rowComposite;
        } else {
            var rowComposite = rowValues[rowValue];
            if (rowComposite.count == 1) {
                $(rowComposite.row).css('backgroundColor', 'red');
            }
            $(this).css('backgroundColor', 'red');
            rowComposite.count++;
        }
    });
});
	/*$('table').dataTable()
	var table = $('#insloadtable').DataTable();
    $('#insloadtable tbody').on('click', 'td', function () {
        //console.log(table.row(this).data());
        $(".modal-body div span").text("");
        $(".scheddays span").text(table.row(this).data()[1]);
        $(".time span").text(table.row(this).data()[2]);
        $(".course span").text(table.row(this).data()[3]);
        $(".description span").text(table.row(this).data()[4]);
        $(".units span").text(table.row(this).data()[5]);
        $(".room span").text(table.row(this).data()[6]);
		$(".instructor span").text(table.row(this).data()[7]);
        $("#myModal").modal("show");
    });*/
</script>