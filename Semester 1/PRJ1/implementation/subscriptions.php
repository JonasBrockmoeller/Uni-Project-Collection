<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors',0);
    
    $emailaddress = $_SESSION['email_address'];
    $account_type = $_SESSION['account_type'];

    echo'
    <!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    -->
    <html>
    <link rel="stylesheet" href="/css/subscriptions.css">
    
    <head>
    <title>Subscriptions</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
    <h1> The 4 Subscription Types</h1>
    
    <hr style= "border: 1pt solid #527a7a;">

    
                <div id="cards" class="card_visitor">
                    <h1 style= "color: #b3b300;"> Visitor </h1>
            
                        <h2> Visitors can: </h2>
                        <h4> play teasers </h4>
                        <h4> navigate on the website </h4>
            
                        <br>
            
                        <hr style= "border: 1pt solid #000000;">
                        <h1> Price: </h1>
                        <h1> FREE </h1>
                </div>
            
                <div id="cards" class="card_listener">
                    <h1 style= "color: #00802b;"> Listener </h1>
            
                        <h2> Listeners can: </h2>
                        <h4> access all Songs in full length </h4>
                        <h4> play, save and like Songs </h4>
            
                        <br>
            
                        <hr style= "border: 1pt solid #000000;">
                        <h1> Price: </h1>
                        <h1> $ 5.99 </h1>
                </div>
            
                <div id="cards" class="card_premium_listener">
                        <h1 style= "color: #9900cc"> Premium </h1>
            
                        <h2> Premium Listeners can: </h2>
                        <h4> play, save and like Songs </h4>
                        <h4> get everything for 50% off </h4>
            
                        <br>
            
                        <hr style= "border: 1pt solid #000000;">
                        <h1> Price: </h1>
                        <h1> $ 9.99 </h1>
                </div>
            
                <div id="cards" class="card_creator">
                    <h1 style= "color: #cc7a00"> Creator </h1>
            
                        <h2> Creators can: </h2>
                        <h4> play all Songs and upload their own ones </h4>
                        <h4> use all listening and crating pages </h4>
            
                        <br>
            
                        <hr style= "border: 1pt solid #000000;">
                        <h1> Price: </h1>
                        <h1> $ 14.99 </h1>
                </div>
    
    </div>
    
    <br>
    
    <br>
    ';
    
if($account_type!='visitor'){
    echo'<a href="change_subscriptions.php" target="_parent"><button>Change your Subscription now</button></a>';
}
    
echo'
    </body>
</html>
';
    ?>

