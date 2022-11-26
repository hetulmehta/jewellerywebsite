<?php
require('db.php');
include("auth_session.php");
?>
<?php 
    require 'includes/PHPMailer.php';
    require 'includes/Exception.php';
    require 'includes/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    $mail = new PHPMailer();
?>
<?php
if (isset($_POST['submit'])) {
    $query1    = "SELECT * FROM `users` WHERE username='$_SESSION[username]' ";
    $result1 = mysqli_query($con, $query1) or die(mysql_error());
    $row1 = mysqli_fetch_assoc($result1);
    $user = $row1['id'];
    $add1 = $_POST['address'];
    $add2 = $_POST['city'];
    $add3 = $_POST['state'];
    $name1 = $_POST['firstname'];
    $email1 = $_POST['email'];
    $last = substr($_POST['cardnumber'], -4);
    $address = $_POST['address'] . ',' . $_POST['city'] . ',' . $_POST['state'];
    $create_datetime = date("Y-m-d H:i:s");
    $query    = "INSERT into `user_details` (user_id,name,delivery_address,zipcode,email,date_created)
                     VALUES ('$user','$_POST[firstname]','$address','$_POST[zip]','$_POST[email]','$create_datetime')";
    $result   = mysqli_query($con, $query);
    if (!$result) {
        echo ("Error description: " . mysqli_error($con));
    }
    $query = "SELECT * FROM cart where user_id='$user'";
    $cart = mysqli_query($con, $query) or die(mysql_error());
    $order_id = uniqid();
    while ($row = $cart->fetch_assoc()) :

        $query    = "INSERT into `orders` (order_id,user_id,product_id,qty,price,date_created)
                     VALUES ('$order_id','$user','$row[product_id]','$row[qty]','$row[price]','$create_datetime')";
        $result   = mysqli_query($con, $query);
        if (!$result) {
            echo ("Error description here: " . mysqli_error($con));
        }
    endwhile;

    $query    = "INSERT into `payment` (order_id,user_id,cardname,cardno,expmonth,expyear,cvv,date_created)
                     VALUES ('$order_id','$user','$_POST[cardname]','$_POST[cardnumber]','$_POST[expmonth]','$_POST[expyear]','$_POST[cvv]','$create_datetime')";
    $result   = mysqli_query($con, $query);

    if (!$result) {
        echo ("Error description not here: " . mysqli_error($con));
    }

    $query    = "DELETE FROM `cart` where user_id='$user'";
    $result   = mysqli_query($con, $query);

    if (!$result) {
        echo ("Error description not here: " . mysqli_error($con));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="invoice.css">
    <title>INVOICE</title>
</head>

<body>
    <div class="container">

        <table width="100%">
            <tr>
                <td width="75px">
                    <div class="logotype">EMBELORN</div>
                </td>
                <td width="300px">
                    <div style="background: #ffd9e8;border-left: 15px solid #fff;padding-left: 30px;font-size: 26px;font-weight: bold;letter-spacing: -1px;height: 73px;line-height: 75px;">Order invoice</div>
                </td>
                <td></td>
            </tr>
        </table>
        <br><br>
        <h3>Hello <?php echo $name1 ?>,</h3>
        <p>Thank you for shopping with us. We'll send a confirmation when your items ship.</p><br>
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td widdth="50%" style="background:#eee;padding:20px;">
                    <strong>Date:</strong><?php echo $create_datetime ?><br>
                    <strong>Payment type:</strong> Credit Card VISA<br>
                    <strong>Delivery type:</strong> Postnord<br>
                </td>
                <td style="background:#eee;padding:20px;">
                    <strong>Order-nr:</strong> <?php echo $order_id ?><br>
                    <strong>Name:</strong><?php echo $name1 ?><br>
                    <strong>Email:</strong><?php echo $email1 ?> <br>
                </td>
            </tr>
        </table><br>
        <table width="100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="vertical-align: text-top;">
                                <div style="background: #ffd9e8 url(https://cdn0.iconfinder.com/data/icons/commerce-line-1/512/comerce_delivery_shop_business-07-128.png);width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 42px;"></div>
                            </td>
                            <td>
                                <strong>Delivery</strong><br>
                                <?php echo $name1 ?><br>
                                <?php echo $add1 ?><br>
                                <?php echo $add2 ?><br>
                                <?php echo $add3 ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td style="vertical-align: text-top;">
                                <div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/app-custom-ui-1/48/Check_circle-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;"></div>
                            </td>
                            <td>
                                <strong>Delivery</strong><br>
                                <?php echo $name1 ?><br>
                                <?php echo $add1 ?><br>
                                <?php echo $add2 ?><br>
                                <?php echo $add3 ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><br>
        <table width="100%" style="border-top:1px solid #eee;border-bottom:1px solid #eee;padding:0 0 8px 0">
            <tr>
                <td>
                    <h3>Checkout details</h3>Your checkout made by VISA Card **** **** **** <?php echo $last ?>
                <td>
            </tr>
        </table><br>
        <div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/basic-ui-2-line/32/shopping-cart-shop-drop-trolly-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;float: left; margin-bottom: 15px;"></div>
        <h3>Your articles</h3>

        <table width="100%" style="border-collapse: collapse;border-bottom:1px solid #eee;">
            <tr>
                <td width="40%" class="column-header">Article</td>
                <td width="20%" class="column-header">Price</td>
                <td width="20%" class="column-header">Total</td>
            </tr>
            <?php
            $query11 = "SELECT * FROM orders where order_id='$order_id'";
            $cart12 = mysqli_query($con, $query11) or die(mysql_error());
            if (!$cart12) {
                echo ("Error description not here: " . mysqli_error($con));
            }

            $total = 0;
            $count1 = mysqli_num_rows($cart12);
            while ($r = $cart12->fetch_assoc()) :
                $tots = $r['qty']*$r['price'];
                $total = $total + $tots;
                $query3    = "SELECT * FROM `products` WHERE id='$r[product_id]' ";
                $result3 = mysqli_query($con, $query3) or die(mysql_error());
                if (!$result3) {
                    echo ("Error description not here: " . mysqli_error($con));
                }
                $row3 = mysqli_fetch_assoc($result3);
            ?>
                <tr>
                    <td class="row"><span style="color:#777;font-size:11px;"><?php echo $row3['item_code'] ?></span><br><?php echo $row3["name"] ?></td>
                    <td class="row"><?php echo $r['qty'] ?><span style="color:#777">X</span> <?php echo $r['price'] ?></td>
                    <td class="row"><?php echo $tots ?></td>
                </tr>
            <?php endwhile; ?>
        </table><br>
        <table width="100%" style="background:#eee;padding:20px;">
            <tr>
                <td>
                    <table width="300px" style="float:right">
                        <tr>
                            <td><strong>Sub-total:</strong></td>
                            <td style="text-align:right"><?php echo $total ?></td>
                        </tr>
                        <tr>
                            <td><strong>Shipping fee:</strong></td>
                            <td style="text-align:right">$35.00</td>
                        </tr>
                        <tr>
                            <td><strong>Grand total:</strong></td>
                            <td style="text-align:right"><?php echo $total + 35 ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="alert">To ensure your safety, the Delivery Agent will drop the package at your doorstep, ring the doorbell and then move back 2 meters while waiting for you to collect your package. If you are in a containment zone, the agent will call you and request you to collect your package from the nearest accessible point while following the same No-Contact delivery process. </div>
        <div class="socialmedia">We hope to see you again soon <br><strong><small>EMBELORN</small></strong></div>
    </div><!-- container -->
    <?php 
    $mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = "true";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;

$mail->Username = ;
$mail->Password = ;
$mail->isHTML(TRUE);
$mail->Subject = "Order Invoice for ORDER#".$order_id;

$mail->setFrom("hetulmehta08@gmail.com");

$message = '<div class="container">

<table width="100%">
    <tr>
        <td width="75px">
            <div class="logotype">EMBELORN</div>
        </td>
        <td width="300px">
            <div style="background: #ffd9e8;border-left: 15px solid #fff;padding-left: 30px;font-size: 26px;font-weight: bold;letter-spacing: -1px;height: 73px;line-height: 75px;">Order invoice</div>
        </td>
        <td></td>
    </tr>
</table>
<br><br><h3>Hello '. $name1 .',</h3><p>Thank you for shopping with us. We will send a confirmation when your items ship.</p><br>
<table width="100%" style="border-collapse: collapse;">
    <tr>
        <td widdth="50%" style="background:#eee;padding:20px;">
            <strong>Date:</strong> '. $create_datetime.'<br>
            <strong>Payment type:</strong> Credit Card VISA<br>
            <strong>Delivery type:</strong> Postnord<br>
        </td>
        <td style="background:#eee;padding:20px;">
            <strong>Order-nr:</strong> '. $order_id .'<br>
            <strong>Name:</strong>'. $name1 .'<br>
            <strong>Email:</strong>'. $email1.' <br>
        </td>
    </tr>
</table><br>
<table width="100%">
    <tr>
        <td>
            <table>
                <tr>
                    <td style="vertical-align: text-top;">
                        <div style="background: #ffd9e8 url(https://cdn0.iconfinder.com/data/icons/commerce-line-1/512/comerce_delivery_shop_business-07-128.png);width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 42px;"></div>
                    </td>
                    <td>
                        <strong>Delivery</strong><br>
                        '. $name1.'<br>
                        '. $add1 .'<br>
                        '. $add2 .'<br>
                        '. $add3 .'<br>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td style="vertical-align: text-top;">
                        <div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/app-custom-ui-1/48/Check_circle-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;"></div>
                    </td>
                    <td>
                        <strong>Delivery</strong><br>
                        '. $name1 .'<br>
                        '. $add1 .'<br>
                        '. $add2 .'<br>
                        '. $add3 .'<br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table><br>
<table width="100%" style="border-top:1px solid #eee;border-bottom:1px solid #eee;padding:0 0 8px 0">
    <tr>
        <td>
            <h3>Checkout details</h3>Your checkout made by VISA Card **** **** **** '. $last .'
        <td>
    </tr>
</table><br>
<div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/basic-ui-2-line/32/shopping-cart-shop-drop-trolly-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;float: left; margin-bottom: 15px;"></div>
<h3>Your articles</h3>

<table width="100%" style="border-collapse: collapse;border-bottom:1px solid #eee;">
    <tr>
        <td width="40%" class="column-header">Article</td>
        <td width="20%" class="column-header">Price</td>
        <td width="20%" class="column-header">Total</td>
    </tr>';
    $query11 = "SELECT * FROM orders where order_id='$order_id'";
    $cart12 = mysqli_query($con, $query11) or die(mysql_error());
    if (!$cart12) {
        echo ("Error description not here: " . mysqli_error($con));
    }

    $total = 0;
    $count1 = mysqli_num_rows($cart12);
    while ($r = $cart12->fetch_assoc()) :
        $tots = $r['qty']*$r['price'];
        $total = $total + $tots;
        $query3    = "SELECT * FROM `products` WHERE id='$r[product_id]' ";
        $result3 = mysqli_query($con, $query3) or die(mysql_error());
        if (!$result3) {
            echo ("Error description not here: " . mysqli_error($con));
        }
        $row3 = mysqli_fetch_assoc($result3);
        $message=$message .'
        <tr>
            <td class="row"><span style="color:#777;font-size:11px;">'. $row3['item_code'] .'</span><br>'. $row3["name"] .'</td>
            <td class="row">'. $r['qty'] .'<span style="color:#777">X</span> '. $r['price'] .'</td>
            <td class="row">'. $tots .'</td>
        </tr>';
    endwhile;
$message=$message.'</table><br>
<table width="100%" style="background:#eee;padding:20px;">
    <tr>
        <td>
            <table width="300px" style="float:right">
                <tr>
                    <td><strong>Sub-total:</strong></td>
                    <td style="text-align:right">'. $total .'</td>
                </tr>
                <tr>
                    <td><strong>Shipping fee:</strong></td>
                    <td style="text-align:right">$35.00</td>
                </tr>
                <tr>
                    <td><strong>Grand total:</strong></td>
                    <td style="text-align:right">'. $total + 35 .'</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="alert">To ensure your safety, the Delivery Agent will drop the package at your doorstep, ring the doorbell and then move back 2 meters while waiting for you to collect your package. If you are in a containment zone, the agent will call you and request you to collect your package from the nearest accessible point while following the same No-Contact delivery process. </div>
<div class="socialmedia">We hope to see you again soon <br><strong><small>EMBELORN</small></strong></div>
</div>' ;

$mail->Body = $message;

$mail->addAddress("$email1");

if( $mail-> send()){
    echo ("<script LANGUAGE='JavaScript'>
window. alert('The invoice has been sent to your email.');
</script>");
}
else{
    echo ("<script LANGUAGE='JavaScript'>
window. alert('Email not sent');
</script>");
}

$mail->smtpClose();

?>

</body>

</html>