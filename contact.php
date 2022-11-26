<!DOCTYPE html>
<html>
  <head>
    <title>Contact us</title>
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"/>
    <style>
    .content {
    display: flex;
    justify-content: center;
    align-items: center;
    
    }
    </style>
  </head>
  <body>

  <?php
    // define variables and set to empty values
    $nameErr = $emailErr = $genderErr = $mobileErr = $CheckErr = "";
    $name = $email = $gender = $mobile = $message = $Check = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "*Please Enter your name";
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
        }
    }
    
    if (empty($_POST["email"])) {
        $emailErr = "*Please Enter your email";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        }
    }

    if(empty($_POST["Number"])){
        $mobileErr = "*Please Enter your mobile number";
    } else {
        $mobile = test_input($_POST["Number"]);
        //Mobile Format validation
        if (!preg_match ("/^[0-9]*$/", $mobile)){
        $mobileErr = "*Invalid Mobile Number";
        }
        if (strlen($mobile)!=10){
        $mobileErr = "*Please enter a ten digit number";
        }
    }

    if (empty($_POST["message"])) {
        $message = "";
    } else {
        $message = test_input($_POST["message"]);
    }

    if (empty($_POST["gender"])) {
        $genderErr = "*Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }
    }

    if(isset($_POST["Check"]) && $_POST['Check']!="")
    {
    $Check = test_input($_POST["Check"]);
    }
    else{
    $CheckErr = "*Please check the box to complete submission";
    }
    
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
?>


<nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">EMBELORN</label>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a class = 'active' href="#">Contact Us</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <br><br><br>
     
    <div class = 'content'>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="decor" style='margin: 20px;'>
      <div class="form-inner">
        <h1>Contact us</h1>
        <input type="text" placeholder="Name" name="name" value="<?php echo $name;?>">
        <span class="error"><?php echo $nameErr;?></span>
        <input type="email" placeholder="Email" name="email" value="<?php echo $email;?>">
        <span class="error"><?php echo $emailErr;?></span>
        <input type="text"  placeholder="Mobile Number" name="Number" value="<?php echo $mobile;?>">
        <span class="error"><?php echo $mobileErr;?></span>
        <textarea placeholder="Message..." name= "message" rows="5" cols = "30"></textarea>
        <div class = "gender" >
            <label>GENDER:</label><br><br>
            Female <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">
            Male<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">
            Other<input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other"> 
        </div>
        <span class="error"> <?php echo $genderErr;?></span>
        <div class = "robot">
        <label>I'm not a robot</label>
        <input type="checkbox" name="Check" >
        </div>
        <span class="error"><?php echo $CheckErr;?></span>
       
        <button type="submit" href="/">Submit</button>
      </div>
    </form> 
  </div>
    
    <div class = "input">
        <?php
        if(isset($_POST['submit'])){
            if ($nameErr=="" && $emailErr=="" &&
            $genderErr=="" && $mobileErr=="" && $CheckErr==""){
        echo "<h2>Your Input:</h2>";
        echo $name;
        echo "<br>";
        echo $email;
        echo "<br>";
        echo $message;
        echo "<br>";
        echo $gender;
            }
        }
        ?>
    </div>
    

  </body>
</html>