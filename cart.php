<?php
require('db.php');
include("auth_session.php");
?>

<head>
  
<link rel="stylesheet" href="cartui.css">
    <title>Cart</title>
  
</head>
<body>
<nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">EMBELORN</label>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a class="active" href="#">Cart</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <br><br><br>

  <div id="w">
    <header id="title">
      <h1>Shopping Cart </h1>
    </header>
    <div id="page">
      <table id="cart">
        <thead>
          <tr>
            <th class="first">Image</th>
            <th class="second">Qty</th>
            <th class="third">Product</th>
            <th class="fourth">Total</th>
            <th class="fifth">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Something posted
          
            if (isset($_POST['delete'])) {
              $id = $_POST['product_id'];
            echo $id;
            mysqli_query($con, "DELETE FROM cart WHERE id=$id");
            // header('location: home.php');
            } else {
              echo "here";
              // header('location: home.php');
              // btnSubmit2 
            }
          }
          
          $query1    = "SELECT * FROM `users` WHERE username='$_SESSION[username]' ";
          $result1 = mysqli_query($con, $query1) or die(mysql_error());
          $row1 = mysqli_fetch_assoc($result1);
          $user = $row1['id'];
          $query2 = "SELECT * FROM cart where user_id='$user'";
          $cart = mysqli_query($con, $query2) or die(mysql_error());
          $count = mysqli_num_rows($cart);
          if($count>0){
          $total = 0;
          while ($row = $cart->fetch_assoc()) :
            $tots = $row['qty'] * $row['price'];
            $total = $total + $tots;
            $query3    = "SELECT * FROM `products` WHERE id='$row[product_id]' ";
            $result3 = mysqli_query($con, $query3) or die(mysql_error());
            $row3 = mysqli_fetch_assoc($result3);

            //   echo "id: " . $row["id"].  "<br>";
            // }
            $img = array();
            if(isset($row3['item_code']) && !empty($row3['item_code'])):
                        if(is_dir('assets/uploads/products/'.$row3['item_code'])):
                            $_fs = scandir('assets/uploads/products/'.$row3['item_code']);
                          foreach($_fs as $k => $v):
                              if(is_file('assets/uploads/products/'.$row3['item_code'].'/'.$v) && !in_array($v,array('.','..'))):
                                $img[] = 'assets/uploads/products/'.$row3['item_code'].'/'.$v;
                      endif;
                    endforeach;
                  endif;
            endif;

          ?>
            <tr class="productitm">
              <td><img src='<?php echo $img[0]?>' class="thumb"></td>
              <td><?php echo "<h4>" . $row["qty"] . "</h4>" ?></td>
              <td><?php echo "<h4>" . $row3["name"] . "</h4>" ?></td>
              <td>$<?php echo $tots ?></td>
              <form action="cart.php"  method="post">
              <input type="hidden" name="product_id" value="<?php echo $row['id']?>">
              <td><span class="remove" ><input type="submit"  id="remove" name='delete' value='Delete'></input></span></td>
              </form>
            </tr>
          <?php endwhile; ?>

          <!-- tax + subtotal -->
          <tr class="extracosts">
            <td class="light">Shipping &amp; Tax</td>
            <td colspan="2" class="light"></td>
            <td colspan="1">&nbsp;</td>
            <td>$35.00</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="totalprice">
            <td class="light">Total:</td>
            <td colspan="3">&nbsp;</td>
            <td colspan="2"><span class="thick">$<?php echo $total + 35.00 ?></span></td>
          </tr>

          <!-- checkout btn -->
          <tr class="checkoutrow">
          <form action="order.php"  method="post">
          <input type="hidden" name="total" value="<?php echo $total + 35.00 ?>">
            <td colspan="5" class="checkout"><input type="submit" name='checkout' id="submitbtn" value='Checkout!'></input></td>
          </tr>
        </tbody>
      </table>
      <?php } 
      else{
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Cart Empty!');
        window.location.href='home.php';
        </script>");
      } ?>
    </div>
  </div>
</body>