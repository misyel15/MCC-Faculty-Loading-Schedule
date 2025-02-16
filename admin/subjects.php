<?php include('db_connect.php'); ?>

<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Subject List</b>
                        <span>
                            <button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" data-toggle="modal" data-target="#subjectModal"><i class="fa fa-user-plus"></i> New Entry</button>
                        </span>
                    </div>
                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="filter-course">Filter by Course</label>
                                <select id="filter-course" class="form-control">
                                    <option value="">All Courses</option>
                                    <?php 
                                        $sql = "SELECT * FROM courses";
                                        $query = $conn->query($sql);
                                        while($row= $query->fetch_array()):
                                            $course = $row['course'];
                                    ?>
                                    <option value="<?php echo  $course ?>"><?php echo ucwords($course) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filter-semester">Filter by Semester</label>
                                <select id="filter-semester" class="form-control">
                                    <option value="">All Semesters</option>
                                    <option value="1st">1st Semester</option>
                                    <option value="2nd">2nd Semester</option>
                                    <option value="Summer">Summer</option>
                                </select>
                            </div>
                        </div>

                        <table id="subjectTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Subject</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $subject = $conn->query("SELECT * FROM subjects order by id asc");
                                while($row=$subject->fetch_assoc()):
                                ?>
                                <tr class="subject-row" data-course="<?php echo $row['course'] ?>" data-semester="<?php echo $row['semester'] ?>">
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="">
                                        <p><b>Subject:</b> <?php echo $row['subject'] ?></p>
                                        <p><small><b>Description:</b> <?php echo $row['description'] ?></small></p>
                                        <p><small><b>Total Units:</b> <?php echo $row['total_units'] ?></small></p>
                                        <p><small><b>Lec Units:</b> <?php echo $row['Lec_Units'] ?></small></p>
                                        <p><small><b>Lab Units:</b> <?php echo $row['Lab_Units'] ?></small></p>
                                        <p><small><b>Hours:</b> <?php echo $row['hours'] ?></small></p>
                                        <p><small><b>Course:</b> <?php echo $row['course'] ?></small></p>
                                        <p><small><b>Year:</b> <?php echo $row['year'] ?></small></p>
                                        <p><small><b>Semester:</b> <?php echo $row['semester'] ?></small></p>
                                        <p><small><b>Specialization:</b> <?php echo $row['specialization'] ?></small></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary edit_subject" type="button" data-id="<?php echo $row['id'] ?>" data-subject="<?php echo $row['subject'] ?>" data-description="<?php echo $row['description'] ?>" data-units="<?php echo $row['total_units'] ?>" data-lecunits="<?php echo $row['Lec_Units'] ?>" data-labunits="<?php echo $row['Lab_Units'] ?>" data-course="<?php echo $row['course'] ?>" data-year="<?php echo $row['year'] ?>" data-semester="<?php echo $row['semester'] ?>" data-special="<?php echo $row['specialization'] ?>" data-hours="<?php echo $row['hours'] ?>" data-toggle="modal" data-target="#subjectModal"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-sm btn-danger delete_subject" type="button" data-id="<?php echo $row['id'] ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->

            <!-- Modal -->
            <div class="modal fade" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="subjectModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="subjectModalLabel">Subject Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" id="manage-subject">
                            <div class="modal-body">
                                <input type="hidden" name="id">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Subject</label>
                                        <input type="text" class="form-control" name="subject" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" cols="30" rows='3' name="description" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Total Units</label>
                                        <input type="text" class="form-control" name="units" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Lec Units</label>
                                        <input type="text" class="form-control" name="lec_units" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Lab Units</label>
                                        <input type="text" class="form-control" name="lab_units" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Hours</label>
                                        <input type="number" class="form-control" name="hours" min="0" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="course" class="control-label">Course</label>
                                        <select class="form-control" name="course" id="course" >
                                            <option value="0" disabled selected>Select Course</option>
                                            <?php 
                                                $sql = "SELECT * FROM courses";
                                                $query = $conn->query($sql);
                                                while($row= $query->fetch_array()):
                                                    $course = $row['course'];
                                                ?>
                                            <option value="<?php echo  $course ?>"><?php echo ucwords($course) ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="cyear" class="control-label">Year</label>
                                        <select class="form-control" name="cyear" id="cyear" >
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
                                        <label for="semester" class="control-label">Semester</label>
                                        <select class="form-control" name="semester" id="semester" >
                                            <option value="" disabled selected>Select Semester</option>
                                            <option value="1st">1st</option>
                                            <option value="2nd">2nd</option>
                                            <option value="Summer">Summer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="specialization" class="control-label">Specialization</label>
                                        <select class="form-control" name="specialization" id="specialization" >
                                            <option value="" disabled selected>Select Specialization</option>
                                            <option value="Major">Major</option>
                                            <option value="Minor">Minor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal -->
        </div>
    </div>
</div>

<style>
    td {
        vertical-align: middle !important;
    }

    .datagrid {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
    }

    .datagrid th {
        background-color: #ccc; /* Light gray background */
        color: #000; /* Black text */
        text-align: center;
    }

    .datagrid td {
        padding: 10px;
        text-align: left;
    }

    .datagrid tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .datagrid tbody tr:hover {
        background-color: #ddd;
    }

    .datagrid .btn {
        margin: 2px;
    }
</style>
<script>
$(document).ready(function() {
    $('#subjectTable').DataTable();

    // Handle form submission
    $('#manage-subject').submit(function(e) {
        e.preventDefault();
        
        var valid = true;
        $('#manage-subject input, #manage-subject select, #manage-subject textarea').each(function() {
            if ($(this).val() === "" || $(this).val() === null) {
                valid = false;
                return false;
            }
        });

        if (!valid) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Please fill out all required fields.',
                showConfirmButton: true
            });
            return;
        }

        $.ajax({
            url: 'ajax.php?action=save_subject',
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
                        text: 'Data successfully added!',
                        showConfirmButton: true,
                    }).then(function() {
                        location.reload();
                    });
                } else if(resp == 2){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data successfully updated!',
                        showConfirmButton: true,
                    }).then(function() {
                        location.reload();
                    });
                } else if(resp == 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Subject already exists!',
                        showConfirmButton: true,
                    });
                }
            }
        });
    });

    // Handle delete button click
    $('.delete_subject').click(function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'ajax.php?action=delete_subject',
                    method: 'POST',
                    data: { id: id },
                    success: function(resp) {
                        if (resp == 1) {
                            Swal.fire(
                                'Deleted!',
                                'Your subject has been deleted.',
                                'success'
                            ).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the subject.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });

    // Handle edit button click
    $('.edit_subject').click(function() {
        var $this = $(this);
        $('#manage-subject').find('[name="id"]').val($this.data('id'));
        $('#manage-subject').find('[name="subject"]').val($this.data('subject'));
        $('#manage-subject').find('[name="description"]').val($this.data('description'));
        $('#manage-subject').find('[name="units"]').val($this.data('units'));
        $('#manage-subject').find('[name="lec_units"]').val($this.data('lecunits'));
        $('#manage-subject').find('[name="lab_units"]').val($this.data('labunits'));
        $('#manage-subject').find('[name="hours"]').val($this.data('hours'));
        $('#manage-subject').find('[name="course"]').val($this.data('course'));
        $('#manage-subject').find('[name="cyear"]').val($this.data('year'));
        $('#manage-subject').find('[name="semester"]').val($this.data('semester'));
        $('#manage-subject').find('[name="specialization"]').val($this.data('special'));
    });

    // Filter functionality
    $('#filter-course, #filter-semester').on('change', function() {
        var course = $('#filter-course').val();
        var semester = $('#filter-semester').val();

        $('.subject-row').each(function() {
            var rowCourse = $(this).data('course');
            var rowSemester = $(this).data('semester');

            if ((course === "" || course === rowCourse) && (semester === "" || semester === rowSemester)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
