<?php 

?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Subject List</b>
                        <button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" id="new_user"><i class="fa fa-user-plus"></i> New user</button>
						</span>
                    </div>
					<div class="card-body">
				<table class="table-striped table-bordered col-md-12"> 
				
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Name</th>
					<th class="text-center">Username</th>
					<th class="text-center">Type</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$type = array("","Admin","Staff","Alumnus/Alumna");
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo ucwords($row['name']) ?>
				 	</td>
				 	
				 	<td>
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td>
				 		<?php echo $type[$row['type']] ?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-sm edit_user" data-id="<?php echo $row['id'] ?>"><i class="fa fa fa-0x fa-pen text-primary"></i></button>
								<!--  <button type="button" class="btn btn-danger delete_user" data-id="<?php echo $row['id'] ?>">Delete</button>-->
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>
	</div>
</div>
<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<script>
	$('table').dataTable();

$('#new_user').click(function(){
    uni_modal('New User','manage_user.php');
});

$('.edit_user').click(function(){
    uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'));
});

$('.delete_user').click(function(){
    _conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')]);
});

function delete_user($id){
   
    $.ajax({
        url:'ajax.php?action=delete_user',
        method:'POST',
        data:{id:$id},
        success:function(resp){
            if(resp==1){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data successfully deleted',
					showConfirmButton: true,
					
                }).then(function() {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            }
        }
    });
}

</script>
