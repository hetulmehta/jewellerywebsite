<?php
include("auth_session.php");
require('db.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Embelorn - Home</title>
    <style>
      * {
  padding: 0;
  margin: 0;
  position: relative;
  box-sizing: border-box;
}

html,
body {
  min-height: 100vh;
  padding: 0;
  margin: 0;
  font-family: Roboto, Arial, sans-serif;
  font-size: 14px;
  color: #666;
}

input,
textarea {
  outline: none;
}

body {
  /* display: flex; */
  justify-content: center;
  align-items: center;
  /* padding: 20px; */
  background: #F3BCD4;
}

nav {
  background: white;
  height: 80px;
  width: 100%;
}

label.logo {
  font-size: 35px;
  line-height: 80px;
  padding: 0 100px;
  font-weight: bold;
  font-family: 'Shrikhand', cursive;
  color: #DC146C;
}

nav ul {
  float: right;
  margin-right: 20px;
}

nav ul li {
  display: inline-block;
  line-height: 80px;
  margin: 0 5px;
}

nav ul li a {
  color: #F3BCD4;
  font-size: 17px;
  padding: 7px 13px;
  border-radius: 3px;
  text-transform: uppercase;
}

a.active,
a:hover {
  background: #DC146C;
  transition: .5s;
}

.checkbtn {
  font-size: 30px;
  color: white;
  float: right;
  line-height: 80px;
  margin-right: 40px;
  cursor: pointer;
  display: none;
}

#check {
  display: none;
}

@media (max-width: 952px) {
  label.logo {
      font-size: 30px;
      padding-left: 50px;
  }
  nav ul li a {
      font-size: 16px;
  }
}

@media (max-width: 858px) {
  .checkbtn {
      display: block;
  }
  ul {
      position: fixed;
      width: 100%;
      height: 100vh;
      background: #2c3e50;
      top: 80px;
      left: -100%;
      text-align: center;
      transition: all .5s;
  }
  nav ul li {
      display: block;
      margin: 50px 0;
      line-height: 30px;
  }
  nav ul li a {
      font-size: 20px;
  }
  a:hover,
  a.active {
      background: none;
      color: #0082e6;
  }
  #check:checked~ul {
      left: 0;
  }
}

.listing-section,
.cart-section {
  width: 100%;
  float: left;
  padding: 1%;
  border-bottom: 0.01em solid #dddbdb;
}

.product {
  float: left;
  width: 23%;
  border-radius: 2%;
  margin: 1%;
}

.product:hover {
  box-shadow: 1.5px 1.5px 2.5px 3px rgba(0, 0, 0, 0.4);
  -webkit-box-shadow: 1.5px 1.5px 2.5px 3px rgba(0, 0, 0, 0.4);
  -moz-box-shadow: 1.5px 1.5px 2.5px 3px rgba(0, 0, 0, 0.4);
}

.image-box {
  width: 100%;
  overflow: hidden;
  border-radius: 2% 2% 0 0;
}

.images {
  height: 15em;
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  border-radius: 2% 2% 0 0;
  transition: all 1s ease;
  -moz-transition: all 1s ease;
  -ms-transition: all 1s ease;
  -webkit-transition: all 1s ease;
  -o-transition: all 1s ease;
}

.images:hover {
  transform: scale(1.2);
  overflow: hidden;
  border-radius: 2%;
}

.text-box {
  width: 100%;
  float: left;
  border: 0.01em solid #dddbdb;
  border-radius: 0 0 2% 2%;
  padding: 1em;
}

h2,
h3 {
  float: left;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  font-size: 1em;
  text-transform: uppercase;
  margin: 0.2em auto;
}

.item,
.price {
  clear: left;
  width: 100%;
  text-align: center;
}

.price {
  color: Grey;
}

.description,
button,
input {
  float: left;
  clear: left;
  width: 100%;
  font-family: 'Roboto', sans-serif;
  font-weight: 300;
  font-size: 1em;
  text-align: center;
  margin: 0.2em auto;
  /* background-color: #DC146C; */
}

input:focus {
  outline-color: #fdf;
}

label {
  width: 60%;
}

.text-box input {
  width: 20%;
  clear: none;
}

input[name="button"] {
  width: 15%;
  clear: none;
}

input[name="button"] {
  margin-top: 1em;
}

input[name="button"] {
  padding: 2%;
  background-color: #dfd;
  border: none;
  border-radius: 2%;
  width: 100%;
  align-self: center;
}

input[name="button"]:hover {
  bottom: 0.1em;
}

input[name="button"]:focus {
  outline: 0;
}

input[name="button"]:active {
  bottom: 0;
  background-color: #fdf;
}
</style>
</head>
<body>
<?php
if (isset($_POST['button'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $query    = "SELECT * FROM `products` WHERE id='$product_id' ";
    $result = mysqli_query($con, $query) or die(mysql_error());
    $rows = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $query1    = "SELECT * FROM `users` WHERE username='$_SESSION[username]' ";
    $result1 = mysqli_query($con, $query1) or die(mysql_error());
    $row1 = mysqli_fetch_assoc($result1);

    if ($rows == 1) {
        $query    = "INSERT into `cart` (user_id, product_id,qty,price)
                 VALUES ($row1[id],$product_id,$quantity,$row[price])";
        $result   = mysqli_query($con, $query);
        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Added to cart!');
    window.location.href='home.php';
    </script>");
    }
}

?>
<nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">EMBELORN</label>
      <ul>
        <li><a class="active" href="#">Home</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <br><br><br>

    <div class="listing-section">
        
            <?php
                $products = $con->query("SELECT * FROM products order by rand()");
                while($row = $products->fetch_assoc()):
                    $img = array();
                    if(isset($row['item_code']) && !empty($row['item_code'])):
                                if(is_dir('assets/uploads/products/'.$row['item_code'])):
                                    $_fs = scandir('assets/uploads/products/'.$row['item_code']);
                                  foreach($_fs as $k => $v):
                                      if(is_file('assets/uploads/products/'.$row['item_code'].'/'.$v) && !in_array($v,array('.','..'))):
                                        $img[] = 'assets/uploads/products/'.$row['item_code'].'/'.$v;
                              endif;
                            endforeach;
                          endif;
                    endif;
                ?>
                <div class="product">
              <div class="image-box">
                  <div class="images" style='background-image: url("<?php echo isset($img[0]) ? $img[0] : "no" ?>")' alt="Product Image"></div>
              </div>
            <div class="text-box">
                <h2 class="item"><?php echo $row['name'] ?>
            </h2>
            <h3 class="price">$<?php echo number_format($row['price'],2) ?>
         </h3>
         <p class="description"><?php echo $row['description'] ?>
        </p>
        <label for="item-1-quantity">Quantity:</label>
        <form method="post" action="home.php">
            <input type="number" name="quantity" value="1" min="1" max="<?php echo $quantity?>" id="item-1-quantity"  required>
            <input type="hidden" name="product_id" value="<?php echo $row['id']?>">
            <input type="submit"name="button" value="Add To Cart">
        </form>
     
    </div>
    
</div>
<?php endwhile; ?>
</div>

</body>
</html>