<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"></link>
</head>
<body>
<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            header("Location: home.php");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
   <nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">EMBELORN</label>
      <ul>
        <li><a href="contact.php">Contact Us</a></li>
        <!-- <li><a class="active" href="#">Login</a></li> -->
        
      </ul>
    </nav>
    <br><br><br>

    <div  style='display:flex; margin-top: 130px;'>
    <form class="form" method="post" name="login">
        <div class = "form-inner" >
            <h1 class="login-title">Login</h1>
            <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
            <input type="password" class="login-input" name="password" placeholder="Password"/>
            <!-- <input type="submit" value="Login" name="submit" class="login-button"/> -->
            <button type="submit" value="Login" name="submit" class="login-button">Login</button>
            <p class="link"><a href="register.php">New Registration</a></p>
        </div>
    </form>
    </div>
<?php
    }
?>
</body>
</html>