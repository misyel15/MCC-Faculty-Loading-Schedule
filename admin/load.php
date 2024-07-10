<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <!-- Table Panel -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php
                if (isset($_GET['id'])) {
                    $fid = $_GET['id'];
                    $stmt = $conn->prepare("SELECT *, concat(lastname,', ',firstname,' ',middlename) as name FROM faculty WHERE id = ?");
                    $stmt->bind_param("i", $fid);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result) {
                        while ($frow = $result->fetch_assoc()) {
                            $instname = $frow['name'];
                        }
                        echo '<b>Instructor\'s Load of ' . htmlspecialchars($instname) . '</b>';
                        echo '<button type="button" class="btn btn-success btn-sm float-right" id="print" data-id="' . htmlspecialchars($fid) . '"><i class="fas fa-print"></i> Print</button>';
                    } else {
                        echo 'Error: ' . $conn->error;
                    }
                    $stmt->close();
                } else {
                    echo '<center><h3>Instructor\'s Load</h3></center>';
                }
                ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <label for="" class="control-label col-md-2 offset-md-2">View Loads of:</label>
                    <div class="col-md-4">
                        <select name="faculty_id" id="faculty_id" class="custom-select select2">
                            <option value=""></option>
                            <?php
                            $stmt = $conn->prepare("SELECT *, concat(lastname,', ',firstname,' ',middlename) as name FROM faculty ORDER BY concat(lastname,', ',firstname,' ',middlename) ASC");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['id']) . '"' . (isset($_GET['id']) && $_GET['id'] == $row['id'] ? ' selected' : '') . '>' . ucwords(htmlspecialchars($row['name'])) . '</option>';
                                }
                            } else {
                                echo 'Error: ' . $conn->error;
                            }
                            $stmt->close();
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <table class="table table-bordered table-hover" id="insloadtable">
                    <thead>
                        <tr>
                            <th class="text-center" width="100px">Code</th>
                            <th class="text-center">Descriptive Title</th>
                            <th class="text-center">Day</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Section</th>
                            <th class="text-center">Units (lec)</th>
                            <th class="text-center">Units (lab)</th>
                            <th class="text-center">Total Units</th>
                            <th class="text-center">Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['id'])) {
                            $i = 1;
                            $sumtu = 0;
                            $sumh = 0;
                            $faculty_id = $_GET['id'];
                            $stmt = $conn->prepare("SELECT * FROM loading WHERE faculty=? ORDER BY timeslot_sid ASC");
                            $stmt->bind_param("i", $faculty_id);
                            $stmt->execute();
                            $loads = $stmt->get_result();

                            if ($loads) {
                                while ($lrow = $loads->fetch_assoc()) {
                                    $days = $lrow['days'];
                                    $timeslot = $lrow['timeslot'];
                                    $course = $lrow['course'];
                                    $subject_code = $lrow['subjects'];
                                    $room_id = $lrow['rooms'];
                                    $fid = $lrow['faculty'];

                                    // Initialize variables
                                    $description = '';
                                    $lec_units = '';
                                    $lab_units = '';
                                    $units = '';
                                    $hours = '';

                                    $stmt2 = $conn->prepare("SELECT *, concat(lastname,', ',firstname,' ',middlename) as name FROM faculty WHERE id = ?");
                                    $stmt2->bind_param("i", $fid);
                                    $stmt2->execute();
                                    $faculty = $stmt2->get_result();

                                    if ($faculty) {
                                        while ($frow = $faculty->fetch_assoc()) {
                                            $instname = $frow['name'];
                                        }
                                    } else {
                                        $instname = 'N/A';
                                    }
                                    $stmt2->close();

                                    $stmt3 = $conn->prepare("SELECT * FROM subjects WHERE subject = ?");
                                    $stmt3->bind_param("s", $subject_code);
                                    $stmt3->execute();
                                    $subjects = $stmt3->get_result();

                                    if ($subjects) {
                                        while ($srow = $subjects->fetch_assoc()) {
                                            $description = $srow['description'];
                                            $units = $srow['total_units'];
                                            $lec_units = $srow['Lec_Units'];
                                            $lab_units = $srow['Lab_Units'];
                                            $hours = $srow['hours'];
                                            $sumh += $hours;
                                            $sumtu += $units;
                                        }
                                    }
                                    $stmt3->close();

                                    $stmt4 = $conn->prepare("SELECT * FROM roomlist WHERE id = ?");
                                    $stmt4->bind_param("i", $room_id);
                                    $stmt4->execute();
                                    $rooms = $stmt4->get_result();

                                    if ($rooms) {
                                        while ($roomrow = $rooms->fetch_assoc()) {
                                            $room_name = $roomrow['room_name'];
                                        }
                                    } else {
                                        $room_name = 'N/A';
                                    }
                                    $stmt4->close();

                                    echo '<tr>
                                            <td class="text-center">' . htmlspecialchars($subject_code) . '</td>
                                            <td class="text-center">' . htmlspecialchars($description) . '</td>
                                            <td class="text-center">' . htmlspecialchars($days) . '</td>
                                            <td class="text-center">' . htmlspecialchars($timeslot) . '</td>
                                            <td class="text-center">' . htmlspecialchars($course) . '</td>
                                            <td class="text-center">' . htmlspecialchars($lec_units) . '</td>
                                            <td class="text-center">' . htmlspecialchars($lab_units) . '</td>
                                            <td class="text-center">' . htmlspecialchars($units) . '</td>
                                            <td class="text-center">' . htmlspecialchars($hours) . '</td>
                                        </tr>';
                                }

                                echo '<tr style="height: 20px">
                                        <td class="s4"></td>
                                        <td class="s3"></td>
                                        <td class="s3"></td>
                                        <td class="s3"></td>
                                        <td class="s3"></td>
                                        <td class="s10 softmerge">
                                            <div class="softmerge-inner" style="width:298px;left:-1px">
                                                <span style="font-weight:bold;">Total Number of Units/Hours (Basic)</span>
                                            </div>
                                        </td>
                                        <td class="s11"></td>
                                        <td class="text-center">' . htmlspecialchars($sumtu) . '</td>
                                        <td class="text-center">' . htmlspecialchars($sumh) . '</td>
                                    </tr>';
                            } else {
                                echo 'Error: ' . $conn->error;
                            }
                            $stmt->close();
                        } else {
                            $sumtu = 0;
                            $sumh = 0;
                            $i = 1;
                            $stmt = $conn->prepare("SELECT * FROM loading ORDER BY timeslot_sid ASC");
                            $stmt->execute();
                            $loads = $stmt->get_result();

                            if ($loads) {
                                while ($lrow = $loads->fetch_assoc()) {
                                    $days = $lrow['days'];
                                    $timeslot = $lrow['timeslot'];
                                    $course = $lrow['course'];
                                    $subject_code = $lrow['subjects'];
                                    $room_id = $lrow['rooms'];
                                    $fid = $lrow['faculty'];

                                    // Initialize variables
                                    $description = '';
                                    $lec_units = '';
                                    $lab_units = '';
                                    $units = '';
                                    $hours = '';

                                    $stmt2 = $conn->prepare("SELECT *, concat(lastname,', ',firstname,' ',middlename) as name FROM faculty WHERE id = ?");
                                    $stmt2->bind_param("i", $fid);
                                    $stmt2->execute();
                                    $faculty = $stmt2->get_result();

                                    if ($faculty) {
                                        while ($frow = $faculty->fetch_assoc()) {
                                            $instname = $frow['name'];
                                        }
                                    } else {
                                        $instname = 'N/A';
                                    }
                                    $stmt2->close();

                                    $stmt3 = $conn->prepare("SELECT * FROM subjects WHERE subject = ?");
                                    $stmt3->bind_param("s", $subject_code);
                                    $stmt3->execute();
                                    $subjects = $stmt3->get_result();

                                    if ($subjects) {
                                        while ($srow = $subjects->fetch_assoc()) {
                                            $description = $srow['description'];
                                            $units = $srow['total_units'];
                                            $lec_units = $srow['Lec_Units'];
                                            $lab_units = $srow['Lab_Units'];
                                            $hours = $srow['hours'];
                                            $sumh += $hours;
                                            $sumtu += $units;
                                        }
                                    }
                                    $stmt3->close();

                                    $stmt4 = $conn->prepare("SELECT * FROM roomlist WHERE id = ?");
                                    $stmt4->bind_param("i", $room_id);
                                    $stmt4->execute();
                                    $rooms = $stmt4->get_result();

                                    if ($rooms) {
                                        while ($roomrow = $rooms->fetch_assoc()) {
                                            $room_name = $roomrow['room_name'];
                                        }
                                    } else {
                                        $room_name = 'N/A';
                                    }
                                    $stmt4->close();

                                    echo '<tr>
                                            <td class="text-center">' . htmlspecialchars($subject_code) . '</td>
                                            <td class="text-center">' . htmlspecialchars($description) . '</td>
                                            <td class="text-center">' . htmlspecialchars($days) . '</td>
                                            <td class="text-center">' . htmlspecialchars($timeslot) . '</td>
                                            <td class="text-center">' . htmlspecialchars($course) . '</td>
                                            <td class="text-center">' . htmlspecialchars($lec_units) . '</td>
                                            <td class="text-center">' . htmlspecialchars($lab_units) . '</td>
                                            <td class="text-center">' . htmlspecialchars($units) . '</td>
                                            <td class="text-center">' . htmlspecialchars($hours) . '</td>
                                        </tr>';
                                }

                                echo '<tr style="height: 20px">
                                        <td class="s4"></td>
                                        <td class="s3"></td>
                                        <td class="s3"></td>
                                        <td class="s3"></td>
                                        <td class="s10 softmerge">
                                            <div class="softmerge-inner" style="width:298px;left:-1px">
                                                <span style="font-weight:bold;">Total Number of Units/Hours (Basic)</span>
                                            </div>
                                        </td>
                                        <td class="s11"></td>
                                        <td class="text-center">' . htmlspecialchars($sumtu) . '</td>
                                        <td class="text-center">' . htmlspecialchars($sumh) . '</td>
                                    </tr>';
                            } else {
                                echo 'Error: ' . $conn->error;
                            }
                            $stmt->close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Table Panel -->
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
    td {
        vertical-align: middle !important;
    }
</style>

<script>
    $('#faculty_id').change(function() {
        window.location.href = 'index.php?page=load&id=' + $(this).val();
    });

    $('.edit_schedule').click(function() {
        uni_modal("Manage Job Post", "manage_schedule.php?id=" + $(this).attr('data-id'), 'mid-large');
    });

    $('.delete_schedule').click(function() {
        _conf("Are you sure to delete this schedule?", "delete_schedule", [$(this).attr('data-id')], 'mid-large');
    });

    $('#print').click(function() {
        window.location.href = 'load_generate.php?id=' + $(this).attr('data-id');
    });

    function delete_schedule($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_schedule',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
