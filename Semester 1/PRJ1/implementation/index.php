<?php
session_start();
session_unset();
session_destroy();

echo '<!DOCTYPE html>
<html>
    <head>
        <title>Get Started</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/index.css">
	
    </head>
    <header>
	<a href="index.php">
            <img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png">
            <img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png">
            </a>
	
        <div>

            
            <p style="float:right;text-align: center;font-size:30pt;color: #b79600;position:absolute;top:40pt;left:25%;">Music begins where the possibilities of language end...</p>

        
	
	
         </div>
	</form>
        </div>

        </div>
    </header>
	<body>
	<div id="main-wrapper">
	<div id="content">
	<a href="homepage.php">
	<button class="getb"><p">Try for free</p></button>
	</a>
	<img src="/source_images/crowd.png" style="width:30%;position:absolute;bottom:22%;left:21.3%;pointer-events:none;"><img src="/source_images/crowd.png" style="width:30%;position:absolute;bottom:22%;right:21.3%;transform: scaleX(-1);pointer-events:none;">
	</div>
	<div>
	<footer style="width:20%;position:absolute;bottom:0;left:0;height:150pt;border-radius: 120pt 120pt 0 0;">
           <a href="login.php"><button class="sch">
	
          <p>Log-in</p>
         </button></a>
    </footer>
	<footer style="width:20%;position:absolute;bottom:0;right:0;height:150pt;border-radius: 120pt 120pt 0 0;">
			<a href="register.php"><button class="sch">
	
          <p>Register</p>
         </button></a>
    </footer>
	<footer style="width:60%;position:absolute;bottom:0;right:20%;height:150pt;border-radius: 20pt 20pt 0 0;">
             <p style="color:#b79600;width:80%;margin-left:10%;margin-top:5%;font-size:15pt;text-align:center;">Songify is a Web-based service that lets users stream songs to their computers or mobile devices. Such services may let users download songs for offline playback as well as allow users to upload their own music collection to the cloud, the latter known as a "music locker."</p>
    </footer>
	</div>
       
    </body>

</html>';

?>
