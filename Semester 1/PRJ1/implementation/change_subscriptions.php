<?php
session_start();
include_once('dbconnect.php');
    error_reporting(E_ALL);
    ini_set('display_errors',0);
  
$emailaddress = $_SESSION['email_address'];
$account_type = $_SESSION['account_type'];

try {
    $stmt = $conn->prepare("SELECT username FROM account WHERE email = ?");
    $stmt->execute([$emailaddress]);
    $dataU = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
    echo "Creation failed: " . $e->getMessage();
}
$pfpname = preg_replace('/\s+/', '%20', $dataU[0]);
    
try{
    $queryw3 = "select credit from payments where account_username='$pfpname'";
    $dataw3=$conn->query($queryw3);
}
catch(PDOException $e)
{
    echo "Creation failed: " . $e->getMessage();
}
foreach($dataw3 as $tempw3){$credit=$tempw3['credit'];break;}

//form itself
echo'
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <link rel="stylesheet" href="css/register.css">

    <head>
        <title>Change Subscription</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>

        <aside>

            <img class="asidePic" src="source_images/main-qimg-1e1a36a42698c414db02aa23bf5ea412.png" style="transform: scaleX(-1);pointer-events:none;">

        </aside>

        <section>
                <div class="container">
    
                    <form action="change_subscriptions.php" method = "post">
    
                        <a href="homepage.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>

                        <h1>You are logged in as:</h1>
                        <h2>Your email: '.$emailaddress.' </h2>
                        <h2> You are currently a: '.$account_type.'</h2>
                        <h2>Your credit currently is: '.$credit.' €</h2>
    
                        <hr>
    
                        <h3>Please select your new subscription plan: </h3>
    
                        <fieldset style="border-style: none; padding: 10pt; display: block;font-size: 18pt;margin-left: 33%;margin-right: auto; ">
                            <div>
                            <input type="radio" id="li" name="subscription" value="Listener">
                            <label for="li"> Listener</label>
                            </div>
    
                            <div>
                            <input type="radio" id="pli" name="subscription" value="Premium Listener">
                            <label for="pli"> Premium Listener</label>
                            </div>
    
                            <div>
                            <input type="radio" id="cr" name="subscription" value="Become Creator">
                            <label for="cr"> Become Creator</label>
                            </div>
    
                        </fieldset>
    
                        <button type="submit" class="registerbtn">Save & Apply</button>
                    </form>

                </div>

                <div class="container signin">
                    <hr>
					<form method = "post">
                        <p>Cancel subscription? Click here:</p>
					    <button type="submit" class="registerbtn" name="cancel" style="width:220pt;">Cancel subscription</button>
					</form>
                </div>
    
        </section>
    </body>
</html>
';

switch ($_POST['subscription'])
{
    case 'Listener':
        try {
            $query="UPDATE account SET subscription_id = 2 WHERE email = '$emailaddress'";
            $conn -> query($query);
            echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
        }
        catch(PDOException $e)
        {
        echo "Creation failed: " . $e->getMessage();
        }
        break;
            
    case 'Premium Listener':
        try {
            $query="UPDATE account SET subscription_id = 3 WHERE email = '$emailaddress'";
            $conn -> query($query);
            echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
        }
        catch(PDOException $e)
        {
        echo "Creation failed: " . $e->getMessage();
        }
        break;
            
    case 'Become Creator':
        echo '<meta http-equiv="refresh" content="0;URL=change_sub.php"/> ';
        break;
            
}
    
if (isset($_POST['cancel']))
{
    $query="UPDATE account SET subscription_id = 0 WHERE email = '$emailaddress'";
    $conn -> query($query);
    echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
}

?>
