<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>School Faculty Scheduling System</title>
  <?php include('./header.php'); ?>
  <?php 
  if(isset($_SESSION['login_name']))
    header("location:index.php?page=home");
  ?>
  <style>
  body {
  width: 100%;
  height: calc(100%);
  font-family: 'CustomFont', Arial, sans-serif; /* Fallback fonts */
}

main#main {
  width: 100%;
  height: calc(100%);
  background: white;
  font-family: 'CustomFont', Arial, sans-serif; /* Fallback fonts */
}

    #login-right {
      position: absolute;
      right: 0;
      width: 40%;
      height: calc(100%);
      background: white;
      display: flex;
      align-items: center;
    }

    #login-left {
      position: absolute;
      left: 6.5%;
      width: 60%;
      height: calc(100%);
      background: #211a19;
      display: flex;
      align-items: center;
      background: url(assets/uploads/back.png);
      background-repeat: no-repeat;
      background-size: contain;
    }

    #login-right .card {
      margin: auto;
      z-index: 1
    }

    .logo {
      margin: auto;
      font-size: 8rem;
      background: white;
      padding: .5em 0.7em;
      border-radius: 50% 50%;
      color: #000000b3;
      z-index: 10;
    }

    div#login-right::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: calc(100%);
      height: calc(100%);
      background: #000000e0;
    }

    .input-icon {
      position: absolute;
      top: 50%;
      left: 10px;
      transform: translateY(-50%);
      color: #777;
    }

    .form-group {
      position: relative;
    }

    .form-control {
      padding-left: 40px;
    }

    .eye-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #777;
      transition: color 0.3s ease; /* Smooth transition for color change */
    }

    .eye-icon.fa-eye-slash {
      /* Adjust color to show closed eye icon */
      color: #777;
    }

    .eye-icon:hover {
      color: #333; /* Hover color when eye icon is clickable */
    }
    .card {
  border: 3px solid #ddd; /* Add a light gray border */
  border-radius: 5px; /* Optional: Rounded corners */
  padding: 15px; /* Optional: Padding inside the card */
}

  </style>

</head>

<body>
  <main id="main" class=" bg-dark">
    <div id="login-left">
    </div>

    <div id="login-right" style="box-shadow: 0 0 10px black;">
  <div class="card col-md-8" style="box-shadow: 0 0 10px black;">
    <div class="card-body">
      <b><center><h1>Login</h1></center></b>
      <form id="login-form">
        <div class="form-group">
         <b> <label for="username" class="control-label">Username</label></b>
          <div style="position: relative;">
            <i class="fas fa-user input-icon"></i> <!-- User icon -->
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" required="" style="box-shadow: 0 0 10px black;">
          </div>
        </div>
        <div class="form-group">
         <b> <label for="password" class="control-label">Password</label></b>
          <div style="position: relative;">
            <i class="fas fa-lock input-icon"></i> <!-- Lock icon -->
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required="" style="box-shadow: 0 0 10px black;">
            <i class="fas fa-eye-slash eye-icon" id="togglePassword" style="box-shadow: 0 0 10px black;"></i> <!-- Initially closed eye -->
          </div>
        </div>
        <b><center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary" style="box-shadow: 0 0 10px black;">Login</button></center></b>
      </form>
    </div>
  </div>
</div>
  </main>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-UZqjsqdXWjv2QvdqCz99XRU9QH7KMXvR3Ma/0AULUn8g0m9vQW23R+KFkzRr/5XKb4WHsleFl5dW5x3Q9L3Qvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function(e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // Toggle the eye icon classes for flash effect
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');

    // Timeout to revert back to initial state after 500ms
    setTimeout(() => {
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    }, 500); // Adjust timing as needed for your desired flash effect
  });

  $('#login-form').submit(function(e) {
    e.preventDefault();
    $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
    if ($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'ajax.php?action=login',
      method: 'POST',
      data: $(this).serialize(),
      error: function(err) {
        console.log(err);
        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
      },
      success: function(resp) {
        if (resp == 1) {
          location.href = 'index.php';
        } else {
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
          $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
        }
      }
    });
  });
});
</script>
</body>

</html>
