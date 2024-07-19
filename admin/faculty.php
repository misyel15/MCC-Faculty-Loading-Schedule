<?php include('db_connect.php');?>
<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid" style="margin-left: 1%;">
<style>
	input[type=checkbox] {
		/* Double-sized Checkboxes */
		-ms-transform: scale(1.5); /* IE */
		-moz-transform: scale(1.5); /* FF */
		-webkit-transform: scale(1.5); /* Safari and Chrome */
		-o-transform: scale(1.5); /* Opera */
		transform: scale(1.5);
		padding: 10px;
	}
	.container {
		height: 1000px; /* Set the desired height */
		overflow-y: auto; /* Add vertical scroll if content overflows */
	}
</style>
	<div class="col-lg-12">
		
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>faculty List</b>
						<span class="">

							<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_faculty">
					<i class="fa fa-user-plus"></i> New Entry</button>
				</span>
					</div>
					<div class="card-body">
						
						<table class="table table-bordered table-condensed table-hover">
							<colgroup>
								<col width="5%">
								<col width="20%">
								<col width="30%">
								<col width="20%">
								<col width="10%">
								<col width="15%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">ID No</th>
									<th class="">Name</th>
									<th class="">Email</th>
									<th class="">Contact</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$faculty =  $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from faculty order by concat(lastname,', ',firstname,' ',middlename) asc");
								while($row=$faculty->fetch_assoc()):
								?>
								<tr>
									
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p><b><?php echo $row['id_no'] ?></b></p>
										 
									</td>
									<td class="">
										 <p><b><?php echo ucwords($row['name']) ?></b></p>
										 
									</td>
									<td class="">
										 <p><b><?php echo $row['email'] ?></b></p>
									</td>
									<td class="text-right">
										 <p><b><?php echo $row['contact'] ?></b></p>
										 
									</td>
									<td class="text-center">
										<button class="btn btn-sm view_faculty" type="button" data-id="<?php echo $row['id'] ?>" >
										<i class="fa fa fa-0x fa-eye text-secondary"></i></button>
										<button class="btn btn-sm edit_faculty" type="button" data-id="<?php echo $row['id'] ?>" ><i class="fas fa-0x fa-edit text-primary"></i></button>
										<button class="btn btn-sm delete_faculty" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa fa-0x fa-trash-alt text-danger"></i></button>
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
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: 150px;
	}
</style>
<script>
    $(document).ready(function(){
        $('table').dataTable();
    });

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

    function validateForm() {
        let valid = true;
        $('input, select').each(function() {
            if ($(this).val() === '') {
                valid = false;
                return false;
            }
        });
        if (!valid) {
            Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Please fill out all fields before submitting!',
            });
        }
        return valid;
    }

    $(document).on('submit', 'form', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
</script>
