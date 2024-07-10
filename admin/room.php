<?php include('db_connect.php');?>
<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
				<!-- Modal -->
				<div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="roomModalLabel">Room Form</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="" id="manage-room">
									<div class="form-group">
										<label class="control-label">Room ID</label>
										<input type="text" class="form-control" name="room_id" id="room_id">
									</div>
									<div class="form-group">
										<label class="control-label">Room</label>
										<input type="text" class="form-control" name="room" id="room">
									</div>
								</form>
							</div>
							<div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="saveRoomBtn">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal -->
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Room List</b>
						<span class="">
						<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#roomModal"><i class="fa fa-user-plus"></i> New Entry</button>
</span>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Room</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$room = $conn->query("SELECT * FROM roomlist order by id asc");
								while($row=$room->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo  $row['room_id'] ?></td>
									<td class="">
										<p>Room name: <b><?php echo $row['room_name'] ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_room" type="button" data-id="<?php echo $row['id'] ?>" data-room="<?php echo $row['room_name'] ?>" data-room_id="<?php echo $row['room_id'] ?>"><i class="fas fa-edit"></i> Edit</button>
										<button class="btn btn-sm btn-danger delete_room" type="button" data-id="<?php echo $row['id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<script>
    $(document).ready(function(){
        $('table').dataTable();
    });

    // Faculty Management

    $('#new_faculty').click(function(){
        uni_modal("New Entry","manage_faculty.php",'mid-large');
    });

    $('.view_faculty').click(function(){
        uni_modal("Faculty Details","view_faculty.php?id="+$(this).attr('data-id'),'');
    });

    $('.edit_faculty').click(function(){
        uni_modal("Manage Faculty","manage_faculty.php?id="+$(this).attr('data-id'),'mid-large');
    });

    $('.delete_faculty').click(function(){
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_faculty(id);
            }
        });
    });

    function delete_faculty(id){
        
        $.ajax({
            url: 'ajax.php?action=delete_faculty',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if(resp == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Faculty data successfully deleted.',
                        showConfirmButton: true,
                        
                    }).then(function() {
                        location.reload();
                    });
                }
            }
        });
    }

    // Room Management

    function _reset(){
        $('#manage-room').get(0).reset();
        $('#manage-room input').val('');
    }

    $('#saveRoomBtn').click(function() {
    $('#manage-room').submit();
});

$('#manage-room').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: 'ajax.php?action=save_room',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp){
            if(resp == 1){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Room data successfully added.',
                    showConfirmButton: true
                }).then(function() {
                    location.reload();
                });
            } else if(resp == 2){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Room data successfully updated.',
                    showConfirmButton: true
                }).then(function() {
                    location.reload();
                });
            } else if(resp == 3){
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Room name or ID already exists.',
                    showConfirmButton: true
                });
            }
        }
    });
});

    $('.edit_room').click(function(){
        start_load();
        var cat = $('#manage-room');
        cat.get(0).reset();
        cat.find("[name='id']").val($(this).attr('data-id'));
        cat.find("[name='room']").val($(this).attr('data-room'));
        cat.find("[name='room_id']").val($(this).attr('data-room_id'));
        $('#roomModal').modal('show');
        end_load();
    });

    $('.delete_room').click(function(){
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_room(id);
            }
        });
    });

    function delete_room(id){
        
        $.ajax({
            url: 'ajax.php?action=delete_room',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if(resp == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Room data successfully deleted.',
                        showConfirmButton: true,
                    
                    }).then(function() {
                        location.reload();
                    });
                }
            }
        });
    }

    $('table').dataTable();
</script>
