<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($meta['id'])): ?>
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		<?php endif; ?>
		</div>
		<?php if(isset($meta['type']) && $meta['type'] == 3): ?>
			<input type="hidden" name="type" value="3">
		<?php else: ?>
		<?php if(!isset($_GET['mtype'])): ?>
		<div class="form-group">
			<input type="hidden" name="type" value="1">
		</div>
		<?php endif; ?>
		<?php endif; ?>
		

	</form>
</div>
<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<script>
	$('#manage-user').submit(function(e){
    e.preventDefault(); // Prevent default form submission
   
    $.ajax({
        url: 'ajax.php?action=save_user',
        method: 'POST',
        data: $(this).serialize(), // Serialize form data for submission
        success: function(resp){
            if(resp == 1){
                Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data successfully updated!',
                            showConfirmButton: true,
                           
                        }).then(function() {
                            location.reload(); // Reload the page after user acknowledges the success message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                            title: 'Success',
                            text: 'Data successfully updated!',
                            showConfirmButton: true,
                             });
                
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to save data. Please try again later.'
            });
            
        }
    });
});

</script>
