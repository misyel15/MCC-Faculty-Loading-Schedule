<style>
    .collapse a {
        text-indent: 10px;
    }

    nav#sidebar {
        background: #0000 url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) center center/cover no-repeat !important;
        /* Adjusted background styling */
        color: #000; /* Set text color to white */
        height: 1000%; /* Ensures full height */
        position: fixed; /* Fixes sidebar position */
        top: 0;
        left: 0;
        width: 16.5%; /* Fixed width for sidebar */
        z-index: 1; /* Ensures sidebar is on top of other content */
        overflow-x: hidden; /* Hides horizontal overflow */
        padding-top: 60px; /* Padding at the top */
    }

    .sidebar-list {
        list-style-type: none;
        padding: 0;
    }

    .sidebar-list a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: inherit;
    }

    .sidebar-list a:hover {
        background-color: #555;
    }

    .sidebar-list .active {
        background-color: #343a40; /* Active link background color */
    }

    .icon-field {
        margin-right: 10px;
    }
</style>

<nav id="sidebar" style="box-shadow: 0 0 5px black; background-color:white;">
    <div class="sidebar-list">
        <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
        <a href="index.php?page=courses" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-list"></i></span> Course List</a>
        <a href="index.php?page=subjects" class="nav-item nav-subjects"><span class='icon-field'><i class="fa fa-book"></i></span> Subject List</a>
        <a href="index.php?page=faculty" class="nav-item nav-faculty"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Faculty List</a>
        <a href="index.php?page=room" class="nav-item nav-room"><span class='icon-field'><i class="fa-solid fa-school"></i></span> Room List</a>
        <a href="index.php?page=timeslot" class="nav-item nav-timeslot"><span class='icon-field'><i class="fa-solid fa-clock"></i></span> Timeslot List</a>
        <a href="index.php?page=section" class="nav-item nav-section"><span class='icon-field'><i class="fa-solid fa-list"></i></span> Section List</a>
        <a href="index.php?page=roomassigntry" class="nav-item nav-roomassigntry"><span class='icon-field'><i class="fa fa-table" aria-hidden="true"></i></span> Room Assignment</a>
        <a href="index.php?page=class_sched" class="nav-item nav-class_sched"><span class='icon-field'><i class="fa fa-table" aria-hidden="true"></i></span> Class Schedule</a>
        <a href="index.php?page=load" class="nav-item nav-load"><span class='icon-field'><i class="fa fa-table" aria-hidden="true"></i></span> Instructor's Load</a>
        <a href="index.php?page=summary" class="nav-item nav-summary"><span class='icon-field'><i class="fa fa-table" aria-hidden="true"></i></span> Summary</a>
        <a href="index.php?page=export" class="nav-item nav-export"><span class='icon-field'><i class="fa fa-table" aria-hidden="true"></i></span> Export CSV</a>
        <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
        <?php if($_SESSION['login_id'] == 1): ?>
            <!-- Place additional admin-only links here if needed -->
        <?php endif; ?>
    </div>
</nav>

<script>
    $(document).ready(function() {
        $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
    });
</script>
