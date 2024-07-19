<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- Modal for Section Form -->
			<div class="modal fade" id="sectionModal" tabindex="-1" role="dialog" aria-labelledby="sectionModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="sectionModalLabel">Section Form</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" id="manage-section">
								<input type="hidden" name="id">
								<div class="form-group">
									<label for="course" class="col-sm-4 control-label">Course</label>
									<div class="col-sm-12">
										<select class="form-control" name="course" id="course" required>
											<option value="" disabled selected>Select Course</option>
											<?php
											$sql = "SELECT * FROM courses";
											$query = $conn->query($sql);
											while($prow = $query->fetch_assoc()){
												echo "<option value='".$prow['course']."'>".$prow['course']."</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="cyear" class="col-sm-3 control-label">Year</label>
									<div class="col-sm-12">
										<select class="form-control" name="cyear" id="cyear">
											<option value="" disabled selected>Select Year</option>
											<option value="1st">1st</option>
											<option value="2nd">2nd</option>
											<option value="3rd">3rd</option>
											<option value="4th">4th</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<label class="control-label">Section</label>
										<input type="text" class="form-control" name="section" id="section">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" id="saveSectionBtn">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							
						</div>
					</div>
				</div>
			</div>
			<!-- Modal for Section Form -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Section List</b>
						<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#sectionModal"><i class="fa fa-user-plus"></i> New Entry</button>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Section</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$room = $conn->query("SELECT * FROM section order by id asc");
								while($row=$room->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>Course: <b><?php echo $row['course'] ?></b></p>
										<p>Year: <small><b><?php echo $row['year'] ?></b></small></p>
                                        <p>Section: <small><b><?php echo $row['section'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_section" type="button" data-id="<?php echo $row['id'] ?>" data-course="<?php echo $row['course'] ?>" data-cyear="<?php echo $row['year'] ?>" data-section="<?php echo $row['section'] ?>"><i class="fas fa-edit"></i> Edit</button>
										<button class="btn btn-sm btn-danger delete_section" type="button" data-id="<?php echo $row['id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
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
<style>
	td{
		vertical-align: middle !important;
	}
</style>
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Your existing PHP and HTML code -->

<script>
    function _reset(){
        $('#manage-section').get(0).reset();
        $('#manage-section input').val('');
    }

	$('#saveSectionBtn').click(function() {
    $('#manage-section').submit();
});

$('#manage-section').submit(function(e){
    e.preventDefault();
     // Ensure start_load function is defined
    $.ajax({
        url: 'ajax.php?action=save_section',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            end_load(); // Ensure end_load function is defined
            if (resp == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Data successfully added!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    location.reload();
                });
            } else if (resp == 2) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Data successfully updated!',
                    showConfirmButton: true,
                    
                }).then(function() {
                    location.reload();
                });
            } else if (resp == 3) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Entry!',
                    text: 'Section already exists for the given course and year.',
                    showConfirmButton: true
                });
            } else {
                   
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Please fill out all required fields.',
                showConfirmButton: true
            
          
                });
            }
        }
    });
});


    $('.edit_section').click(function(){
        start_load();
        var cat = $('#manage-section');
        cat.get(0).reset();
        cat.find("[name='id']").val($(this).attr('data-id'));
        cat.find("[name='course']").val($(this).attr('data-course'));
        cat.find("[name='cyear']").val($(this).attr('data-cyear'));
        cat.find("[name='section']").val($(this).attr('data-section'));
        $('#sectionModal').modal('show');
        end_load();
    });

    $('.delete_section').click(function(){
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_section(id);
            }
        });
    });

    function delete_section(id){
        
        $.ajax({
            url:'ajax.php?action=delete_section',
            method:'POST',
            data:{id:id},
			success: function(resp) {
                    if (resp == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Data successfully deleted.',
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
