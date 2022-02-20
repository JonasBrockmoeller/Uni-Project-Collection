<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);
include_once('dbconnect.php');

if(isset($_SESSION['email'])){
$emailaddress = $_SESSION['email'];
} elseif(isset($_SESSION['email_address'])){
$emailaddress = $_SESSION['email_address'];
}

$password = $_SESSION['password'];

$_SESSION['email_address'] = $emailaddress;
$_SESSION['password'] = $password;

$_SESSION['searched']=$_POST['searched'];
$search = $_SESSION['searched'];

$_SESSION['searchedsong']=$_POST['searchedsong'];
$searchedsong = $_SESSION['searchedsong'];

$_SESSION['playingSong']=$_POST['playingSong'];
$playingSong = $_SESSION['playingSong'];

$_SESSION['NameplayingSong']=$_POST['NameplayingSong'];
$NameplayingSong = $_SESSION['NameplayingSong'];

$_SESSION['ArtistplayingSong']=$_POST['ArtistplayingSong'];
$ArtistplayingSong = $_SESSION['ArtistplayingSong'];

$_SESSION['isTeaser']=$_POST['isTeaser'];
$isTeaser = $_SESSION['isTeaser'];

$_SESSION['ratedSong']=$_POST['ratedSong'];
$ratedSong = $_SESSION['ratedSong'];

$_SESSION['isLike']=$_POST['isLike'];
$isLike = $_SESSION['isLike'];

$_SESSION['isDownload']=$_POST['isDownload'];
$isDownload = $_SESSION['isDownload'];

$_SESSION['listening_price']=$_POST['listening_price'];
$listening_price = $_SESSION['listening_price'];

$_SESSION['download_price']=$_POST['download_price'];
$download_price = $_SESSION['download_price'];


try {
$query1 = "SELECT subscription.name FROM public.subscription inner join public.account on subscription.id=account.subscription_id WHERE account.email=?";
$stmt = $conn->prepare($query1);
$stmt->execute([$emailaddress]);
$data1 = $stmt->fetch(PDO::FETCH_NUM);

}
catch(PDOException $e)
{
	echo "Creation failed: " . $e->getMessage();
}

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
$account_type = $data1[0];

if(!isset($emailaddress)){
  $account_type = "visitor";
}



$filecheck = 'images/profile_pictures/circle_'.$dataU[0].'.png';
echo '<!DOCTYPE html>
<html>
    <head>
        <title>Terms of services</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/newcss.css">
    </head>';
    if($account_type != 'visitor'){
      echo'
    <header>
        <div>
            <a href="homepage.php">
            <img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png">
            <img class="headP" src="/source_images/cap.png">';

            if($account_type != 'visitor' && file_exists($filecheck) == TRUE){
            echo'
						<a href="profile_page.php">
            <img class="headPr" src="/images/profile_pictures/circle_'.$pfpname.'.png">
						<img class="headPr" src="/images/profile_pictures/circle_'.$pfpname.'.png">
						  </a>';}
						elseif($account_type != 'visitor' && file_exists($filecheck) == FALSE){
							echo'
							<a href="profile_page.php">
							<img class="headPr" src="/source_images/profile_icon_blue.png" width="120" height="100">
							<img class="headPr" src="/source_images/profile_icon_blue.png" width="120" height="100">
							  </a>';}
            echo'
            </a>';

            if(isset($emailaddress)){
              echo'<a href="logout.php"><button class="loginButton" style="height:30pt;margin-top:40pt;">Log out</button></a>';
            }

              echo'
                      <div class="wrap">
                          <h2>Music begins where the possibilities of language end...</h2>
                  <form action="search.php" method = "post">
                  <div class="search">
                      <input type="text" class="searchTerm" placeholder="Type in name of song, album, artist..." name="searched" id="searched">
              		<input type="hidden" name="playingSong" value="'.$playingSong.'">
              	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
              	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
              	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
                  <button type="submit" class="searchButton">
                        <p>Search</p>
                       </button>
                       </div>
                  </form>
                      </div>
                      </div>
                  </header><body>';
            }

echo"<body>";
    echo'<h5>Songify Terms of Services</h5>';

    echo"<p  >Our services are subject to the conditions that are listed below, each and every time one makes use of said services. By making use of our services, we assume that the customer consents to the conditions below. This is why we urge you to read these conditions carefully.";

    echo'<h2>Privacy policy</h2>';

    echo"<p  >Privacy is a fundamental human right, and we here at Songify wish to abide by the regulations surrounding the United Nations Privacy Charter article 224 section 64D. It is our duty as a company to ensure that personal information does not get used maliciously.
    When it comes to personal data, there are a variety of things we store based on the user's given input, such as email addresses, usernames, payment credentials, the user's activity on the platform etc.  It is important to state that we, as a company, exercise our right to share certain pieces of information with other organisations/agencies.
     For instance, the user's activity on the website may be exchanged to Third Parties.  On the contrary, Songify ensures that other kinds of data, such as passwords and payment details, never end up in the hands of third parties.  Upon the User's request, these pieces of information can always be removed from our databases.";

    echo'<h2>Copyright</h2>';

    echo"<p  >When it comes to copyright, it should be stated that content published on this website (digital downloads and/or displayings of files, images, texts and logos)  is the property of Songify Inc. and/or its content creators and protected by international copyright laws. The entire compilation of the content found on this website is the exclusive property of Songify Inc.  Any violation of international copyright laws may be met with legal action from federal or other legislative courts.";

		echo'<h2>Community guidelines</h2>';

		echo"<p  >Songify ensures the maintenance of a stable and safe community environment for all its users. In order to achieve this goal, we it has stipulated a number of community guidelines.
		These guidelines fall into three categories: User safety, content appropriateness and protocols regarding account types.  The essence of the first category is that users on this platform do not engage in violent
		or otherwise obscene actions towards other users.   This means that users may not make derogatory, defamatory, discriminatory or racist statements towards others.   The second category is about the content that users can find on Songify. Songify ensures that this content does include illegal or obscene material.
		For the last category, the relationship between different kinds of users is important. For instance, the relationship between a regular, paid user and a content creator. One can go from the former to the latter,
		but there have to be certain restrictions in order to ensure that not everyone can just blatantly upload material which could go unmoderated. Any violation of these rules will be met with punitive action, which includes, 
		but is not limited to: Removal of accounts, disablement of accounts, disablement of functionalities, revokement of creatorship status and so forth. The duration and severity of these penalties depends on the action in question.";

		echo'<h2>User account</h2>';

		echo"<p  >The user has, upon creating an account on Songify.com, the full-time responsibility of maintaining the confidentiability of private user details, such as passwords and payment details.
		Likewise, you are responsible for all actions which occur on behalf of your account.";

		echo'<h2>Legal disputes</h2>';

		echo"<p  >In the event of legal disputes between a user/multiple users and Songify related to their visit to this website and/or their purchasings of content on this website, there shall be an arbitration
		in federal or other jurisdictive courts and you consent to the exclusive jurisdictions of said courts.";

    if($account_type == 'visitor'){
      echo' <p align="justify"><a href="register.php"><button class="gobackbutton" style="height:30pt;margin-top:40pt;">Go back</button></a>';
    }
		if($account_type != 'visitor'){
			echo' <p align="justify"><a href="change_sub.php"><button class="gobackbutton" style="height:30pt;margin-top:40pt;">Go back</button></a>';
		}

 ?>
