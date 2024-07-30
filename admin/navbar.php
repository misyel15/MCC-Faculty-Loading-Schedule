<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  
    <script src="js/jquery.mobile-1.4.5.min.js"></script>
    <style>
        /* Sidebar styling */
        nav#sidebar {
            background: #0000 url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) center center/cover no-repeat !important;
            color: #000;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            width: 16.5%;
            z-index: 1;
            overflow-x: hidden;
            padding-top: 60px;
            transition: all 0.3s ease;
        }

        .sidebar-list {
            list-style-type: none;
            padding: 0;
        }

        .sidebar-list a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
            color: inherit;
            transition: padding 0.3s ease;
        }

        .sidebar-list a:hover {
            background-color: #555;
        }

        .sidebar-list .active {
            background-color: #343a40;
        }

        .icon-field {
            margin-right: 10px;
            transition: margin-right 0.3s ease;
        }

        #menu-toggle {
            position: absolute;
            top: 14px;
            left: 20%;
            background-color: transparent;
            color: white;
            border: none;
            padding: 1px transparent;
            font-size: 20px;
            cursor: pointer;
            z-index: 2;
        }

        .sidebar-collapsed {
            width: 60px;
        }

        .sidebar-collapsed .sidebar-list a {
            padding: 10px;
            justify-content: right;
        }

        .sidebar-collapsed .sidebar-list a .nav-text {
            display: none;
        }

        .sidebar-collapsed .icon-field {
            margin-left: 0;
            font-size: 1.2rem;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .top-navbar {
            width: 100%;
            height: 56px;
            background-color: #800000;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            top: 0;
            z-index: 2;
        }

        .top-navbar .nav-title {
            display: flex;
            align-items: center;
        }

        .top-navbar .nav-title img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .top-navbar .nav-links {
            display: flex;
            align-items: center;
        }

        .top-navbar .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            transition: color 0.3s;
        }

        .top-navbar .nav-links a:hover {
            color: #ddd;
        }

        .top-navbar .dropdown {
            display: flex;
            align-items: center;
            position: relative;
        }

        .dropdown-menu {
            background-color: white;
            border: 1px solid #495057;
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            top: 100%;
            right: 0;
            display: none; /* Hide dropdown by default */
        }

        .dropdown-item {
            color: black;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: #495057;
            color: #ffffff;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
        }

        .fa-user {
            margin-right: 0.5rem;
            font-size: 1.25rem;
        }

        @media (max-width: 768px) {
            nav#sidebar {
                width: 40%;
                left: 0%;
            }

            nav#sidebar.sidebar-collapsed {
                width: 50%;
                left: 0;
            }

            nav#sidebar.sidebar-hidden {
                left: -60%;
            }

            #menu-toggle {
                top: 15px;
                left: 50%;
                transform: translate(-50%, 0);
            }

            .top-navbar .nav-links {
                display: none;
            }

            .top-navbar .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 56px;
                right: 0;
                background-color: #343a40;
                padding: 10px;
                border-radius: 5px;
            }
        }
    </style>
</head>
<body>
    <nav class="top-navbar">
        <button id="menu-toggle"><i class="fas fa-bars"></i></button>
        <div class="nav-title">
            <img src="assets/uploads/back.png" alt="Logo">
            School Faculty Scheduling System
        </div>
        <div class="float-right">             
            <div class="dropdown mr-4">
                <i class="fa fa-user text-secondary" aria-hidden="true"></i>
                <a href="#" class="text-white dropdown-toggle" id="account_settings" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?></a>
                <div class="dropdown-menu" aria-labelledby="account_settings">
                    <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
                    <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

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
            // Highlight current page in sidebar
            $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');

            // Toggle sidebar
            $('#menu-toggle').on('click', function() {
                $('#sidebar').toggleClass('sidebar-collapsed sidebar-hidden');
                $(this).find('i').toggleClass('fa-bars fa-times');
            });

            // Toggle dropdown menu
            $('#account_settings').on('click', function() {
                $('.dropdown-menu').toggle();
            });

            // Manage Account Modal
            $('#manage_my_account').click(function(){
                uni_modal("Manage Account", "manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own");
            });
        });
    </script>
</body>
</html>
