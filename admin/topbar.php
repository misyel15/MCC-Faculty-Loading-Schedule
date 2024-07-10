<style>
  .logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 7px 11px;
    border-radius: 50% 50%;
    color: #000000b3;
  }
  .custom-navbar {
    background-color: #800000; /* Dark red color */
  }
  .side-menu {
    position: fixed;
    top: 0;
    left: -250px;
    width: 250px;
    height: 100%;
    background-color: #333;
    transition: all 0.3s ease;
    z-index: 1000;
    padding-top: 3.5rem; /* Adjust based on your navbar height */
  }
  .side-menu ul {
    list-style: none;
    padding: 0;
  }
  .side-menu li {
    padding: 10px;
    color: #fff;
  }
</style>

<nav class="navbar navbar-light fixed-top custom-navbar" style="padding: 0; min-height: 3.5rem;">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="col-md-1 float-left" style="display: flex;">
       </div>
      <div class="col-md-4 float-left text-white">
        <img src="assets/uploads/back.png" alt="Logo" style="width: 50px; height: 40px; margin-left: -5%; "> &nbsp; &nbsp; <large><b>School Faculty Scheduling System</b></large>
      <!-- Menu icon -->
      &nbsp; &nbsp;<i class="fa fa-bars text-white" id="menuIcon" aria-hidden="true" style="font-size: 1.5rem; cursor: pointer;"></i>
      
      </div>
      <div class="float-right">             
        <div class="dropdown mr-4">
          <i class="fa fa fa-0x fa-user text-secondary" aria-hidden="true"></i>
          <a href="#" class="text-white dropdown-toggle" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?></a>
          <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
            <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
            <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Side menu content (hidden by default) -->
<div class="side-menu" id="sideMenu">
  <ul>
    <li><a href="#">Dashboard</a></li>
    <li><a href="#">Profile</a></li>
    <li><a href="#">Settings</a></li>
    <li><a href="#">Logout</a></li>
  </ul>
</div>

<script>
  // Toggle side menu when menu icon is clicked
  $('#menuIcon').click(function() {
    $('#sideMenu').toggleClass('open');
  });

  // Close side menu when a menu item is clicked (optional)
  $('#sideMenu ul li a').click(function() {
    $('#sideMenu').removeClass('open');
  });

  $('#manage_my_account').click(function(){
    uni_modal("Manage Account","manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own");
  });
</script>
