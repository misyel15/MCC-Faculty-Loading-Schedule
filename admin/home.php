<?php include 'db_connect.php' ?>
<style>
    body {
        background-color: lightgray; /* Light background for the page */
    }
    .main-container {
        background-color: white; /* Set the container's background to white */
        padding: 2rem; /* Add padding for better appearance */
        border-radius: 8px; /* Rounded corners for a modern look */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        max-width: 1340px; /* Set a maximum width */
        margin: 0 auto; /* Center the container */
    }
    span.float-right.summary_icon {
        font-size: 3rem;
        position: absolute;
        right: 1rem;
        color: #ffffff96;
    }
    .imgs {
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }
    .imgs img {
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }
    #imagesCarousel, #imagesCarousel .carousel-inner, #imagesCarousel .carousel-item {
        height: 60vh !important;
        background: black;
    }
    #imagesCarousel .carousel-item.active {
        display: flex !important;
    }
    #imagesCarousel .carousel-item-next {
        display: flex !important;
    }
    #imagesCarousel .carousel-item img {
        margin: auto;
    }
    #imagesCarousel img {
        width: auto !important;
        height: auto !important;
        max-height: calc(100%) !important;
        max-width: calc(100%) !important;
    }
    /* Separate gradient styles for each card */
    .card-1 {
    background: lightgray;
    color: #000;
}
.card-2 {
    background: lightgray;
    color: #000;
}
.card-3 {
    background: lightgray;
    color: #000;
}
.card-4 {
    background: lightgray;
    color: #000;
}

</style>

<div class="container main-container" style="box-shadow: 0 0 0px black;">
    <h3 class="my-4">Welcome Admin!</h3>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="card card-1" style="box-shadow: 0 0 5px black;">
                    <div class="card-body">
                        <div class="icon" style="text-align:right;">
                        <i class="fa fa fa-4x fa-school text-secondary" aria-hidden="true"></i>

                        </div>
                        <?php
                            $sql = "SELECT * FROM roomlist";
                            $query = $conn->query($sql);
                            $num_rooms = $query->num_rows; // Number of rooms

                            echo "<h3>".$num_rooms."</h3>";
                        ?> 
                        <p>Number of Rooms</p>                
                        <hr>
                        <a class="medium text-secondary stretched-link" href="index.php?page=room">View Details</a>
                    </div>
                </div>              
            </div>
            <div class="col-lg-3">
                <div class="card card-2" style="box-shadow: 0 0 5px black;">
                    <div class="card-body">
                        <div class="icon" style="text-align:right;">
                            <i class="fa fa-4x fa-user-tie text-secondary" aria-hidden="true"></i>
                        </div>
                        <?php
                            $sql = "SELECT * FROM faculty";
                            $query = $conn->query($sql);
                            $num_instructors = $query->num_rows; // Number of instructors

                            echo "<h3>".$num_instructors."</h3>";
                        ?>
                        <p>Number of Instructors</p>  
                        <hr>
                        <a class="medium text-secondary stretched-link" href="index.php?page=faculty">View Details</a>
                    </div>
                </div>              
            </div>
            <div class="col-lg-3">
                <div class="card card-3" style="box-shadow: 0 0 5px black;">
                    <div class="card-body">
                        <div class="icon" style="text-align:right;">
                            <i class="fa fa-4x fa-book-open text-secondary" aria-hidden="true"></i>
                        </div>
                        <?php
                            $sql = "SELECT * FROM subjects";
                            $query = $conn->query($sql);
                            $num_subjects = $query->num_rows; // Number of subjects

                            echo "<h3>".$num_subjects."</h3>";
                        ?>
                        <p>Number of Subjects</p>  
                        <hr>
                        <a class="medium text-secondary stretched-link" href="index.php?page=subjects">View Details</a>
                    </div>
                </div>              
            </div>
            <div class="col-lg-3">
                <div class="card card-4" style="box-shadow: 0 0 5px black;">
                    <div class="card-body">
                        <div class="icon" style="text-align:right;">
                            <i class="fa fa-4x fa-graduation-cap text-secondary" aria-hidden="true"></i>
                        </div>
                        <?php
                            $sql = "SELECT * FROM courses";
                            $query = $conn->query($sql);
                            $num_courses = $query->num_rows; // Number of courses

                            echo "<h3>".$num_courses."</h3>";
                        ?>
                        <p>Number of Courses</p>  
                        <hr>
                        <a class="medium text-secondary stretched-link" href="index.php?page=courses">View Details</a>
                    </div>
                </div>              
            </div>
        </div>

        <!-- Bar Chart Container -->
        <div class="row mt-4" >
            <div class="col-lg-7">
                <div class="card" style="box-shadow: 0 0 5px black;">
                    <div class="card-header">
                        <h3>Number of Subjects Per Semester</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="subjectsBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js script to create bar chart for subjects
    $(document).ready(function(){
        var ctxSubjects = document.getElementById('subjectsBarChart').getContext('2d');
        var subjectsBarChart = new Chart(ctxSubjects, {
            type: 'bar',
            data: {
                labels: [
                    '1st Year - 1st Semester', '1st Year - 2nd Semester', 
                    '2nd Year - 1st Semester', '2nd Year - 2nd Semester', 
                    '3rd Year - 1st Semester', '3rd Year - 2nd Semester', '3rd Year - Summer',
                    '4th Year - 1st Semester', '4th Year - 2nd Semester', 
                ],
                datasets: [{
                    label: 'Number of Subjects',
                    data: [/* Example data */ 12, 19, 3, 5, 2, 3, 14, 18, 12, 15, 13, 20], // Replace with actual data
                    backgroundColor: 'skyblue', // Black with 20% opacity
                    borderColor: 'rgba(0, 0, 0, 0)', // Black with full opacity
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
