<?php

session_start();
include_once('dbconnect.php');
error_reporting(E_ALL);
ini_set('display_errors',0);

$email = $_SESSION['email'];
$uname = $_SESSION['uname'];
$_SESSION['cardNumber'] = $_POST['cardNumber'];
$_SESSION['cardholder'] = $_POST['cardholder'];
$_SESSION['cardexpm'] = $_POST['cardexpm'];
$_SESSION['cardexpy'] = $_POST['cardexpy'];
$_SESSION['cvv'] = $_POST['cvv'];
echo'

<html>
    <link rel="stylesheet" href="/css/payment-details.css">

    <head>
        <title>Payment details</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>

        <h1>Payment details</h1>

        <img class="asidePic" src="images/clipart-musician2.png">

        <div class="invoice-box">

            <table>
                <tr class="heading">

                    <td>
                        Item
                    </td>

                    <td>
                        Price
                    </td>

                </tr>

                <tr class="item">
                    <td>
                        Listener basic subscription
                    </td>
                    <td>
                        $9.99
                    </td>
                </tr>

                <tr class="total">
                    <td></td>
                    <td>
                        Total: $9.99
                    </td>
                </tr>

            </table>
        </div>

            <div class="CreditCard">

                <h2>Credit Card Payment</h2>

                <form>
                    <div class="cc-selector">
                        <input id="visa" type="radio" name="credit-card" value="visa"/>
                        <label class="drinkcard-cc visa" for="visa"></label>
                        <input id="mastercard" type="radio" name="credit-card" value="mastercard" checked/>
                        <label class="drinkcard-cc mastercard"for="mastercard"></label>
                    </div>
                </form>

                <form action="payment_details.php" method = "post">
                    <div>
                        <input type="text" class="form-control" name="cardholder" placeholder=" Full name (on the card)" required maxlength="50">
                    </div> <!-- form-group.// -->
                    <div>
                        <input type="text" class="form-control" name="cardNumber" placeholder=" Card Number" maxlength="16">
                    </div> <!-- form-group.// -->
                    <div>
                        <input type="number" class="control_numberfield1" placeholder=" Expiration MM" name="cardexpm" max="12">
                        <input type="number" class="control_numberfield2" placeholder=" Expiration YY" name="cardexpy"max="99">
                    </div>
                    <div>
                        <input type="number" name="cvv" class="form-control" placeholder="CVV" required max="999">
                    </div> <!-- form-group.// -->
                    <p><strong> By pressing confirm you purchase a monthly Songify subscription
                        </strong></p>
                    </br>
                    <button class="confimbtn" type="submit" name="Submit"> Confirm  </button>
                </form>

<!-- Credit card infos// -->

    <hr>

    <h2>PayPal Payment</h2>

        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="EKEJLSRAF2EPW">
            <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">

            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
        </form>

    </div>


<!-- Paypal infos -->';

echo'
    </body>
</html>

';

if(isset($_POST["Submit"]))
{
echo '<meta http-equiv="refresh" content="0;URL=profile_setup.php"/> ';
}
?>
