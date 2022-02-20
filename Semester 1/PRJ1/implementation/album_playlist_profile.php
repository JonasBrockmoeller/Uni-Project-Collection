<?php

session_start();
include_once('dbconnect.php');
error_reporting(E_ALL);
ini_set('display_errors',0);


if(isset($_SESSION['email'])){
$emailaddress = $_SESSION['email'];
} elseif(isset($_SESSION['email_address'])){
$emailaddress = $_SESSION['email_address'];
}

$password = $_SESSION['password'];
$account_type = $_SESSION['account_type'];

$_SESSION['email_address'] = $emailaddress;
$_SESSION['password'] = $password;

$_SESSION['searched']=$_POST['searched'];
$search = $_SESSION['searched'];

$_SESSION['albumpl']=$_POST['albumpl'];
$albumpl = $_SESSION['albumpl'];

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

	$data1 = $conn->query("SELECT subscription.name FROM public.subscription inner join public.account on subscription.id=account.subscription_id WHERE account.email='$emailaddress'");
	$album = $conn->query("select albumplaylist.name, albumplaylist.creator_username, albumplaylist.description, albumplaylist.isalbum from albumplaylist where albumplaylist.id='$albumpl'");
	$dataw = $conn->query("SELECT username FROM public.account WHERE email='$emailaddress'");
		}
		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}
		
		
		foreach($dataw as $tempw){
			$curusername = $tempw['username'];break;}
			
			
echo '<!DOCTYPE html>
<html>
    <head>
        <title>Details</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/newcss.css">

    </head>
    <header>
        <div>

            <a href="homepage.php">
            <img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png">
            <img class="headP" src="/source_images/cap.png">
                <a href="profile_page.php">
                <img class="headPr" src="/images/profile_pictures/circle_'.$curusername.'.png">
                <img class="headPr" src="/images/profile_pictures/circle_'.$curusername.'.png">
                </a>
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
    </header>

    <body>
        <div id="main-wrapper">
        <aside>
         <!--   <h1>Navigational menu</h1>-->';
	if(isset($emailaddress))
	{
		echo "<br>Your email: $emailaddress <br>";
	}
	else{
	echo '<br>You are not registered.<br>';
	$account_type='visitor';
	echo "You are logged in as: $account_type <br><br>";
	}

			
			
try{
	$queryw3 = "select credit from payments where account_username='$curusername'";
$dataw3=$conn->query($queryw3);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
foreach($dataw3 as $tempw3){$credit=$tempw3['credit'];break;}
			
	foreach($data1 as $data){
	$account_type = $data['name'];
	echo '<br>You are logged in as: '.$account_type.'<br>';
		break;
	}

	
		if($account_type!='visitor')echo "Your credit currently is: $credit €<br><br>";
        if($account_type=='listener' || $account_type=='moderator' || $account_type=='premium_listener')echo' <a href="library.php"><button class="button">Library</button></a>';
        if($account_type=='creator' || $account_type=='moderator')echo' <a href="upload_songs.php"><button class="button">Upload</button></a>';
		
        echo '</aside>
	<br><br><br><br>
		<section style="position:absolute;left:25%;top:70%;width:70%;">
        <div id="content">';
		
		
		
        foreach($album as $tname){
			if($tname['isalbum']==true){
		echo'
		<h1 style="text-align:center;">Title of album : '.$tname['name'].'</h1>
		<h2 style="text-align:center;">Description : '.$tname['description'].'</h2>
		<h4 style="text-align:center;">Uploaded by : '.$tname['creator_username'].'</h4>';
		if($account_type=='moderator' || $curusername==$tname['creator_username']){
			echo'
		<form action="edit_album_playlist.php" method="post">
		<input type="hidden" name="albumpl" value="'.$albumpl.'">
		<button type="submit" style="position:relative;background-color:black;color:#9c9279;margin-bottom:10pt;left:50%;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">Edit</button>
		</form>
		
		';break;}
		}
		else {
			echo'
		<img src="/source_images/profile_icon.png" style="position:relative;left:18%;width:100pt;">
		<h1 style="text-align:center;">Title of playlist : '.$tname['name'].'</h1>
		<h2 style="text-align:center;">Description : '.$tname['description'].'</h2>
		<h4 style="text-align:center;">Uploaded by : '.$tname['creator_username'].'</h4>';
		if($account_type=='moderator' || $curusername==$tname['creator_username']){
			echo'
		<form action="edit_album_playlist.php" method="post">
		<input type="hidden" name="albumpl" value="'.$albumpl.'">
		<button type="submit" style="position:relative;background-color:black;color:#9c9279;margin-bottom:10pt;left:50%;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">Edit</button>
		</form>
		
		';break;}
		}
		}
		
		try{
	$data1 = $conn->query("select song_id from album_playlist_songs where album_playlist_id=$albumpl");
	
		echo '		<table class="tbl">
				  <tr>
					<th class="photo">Photo</th>
					<th>Title</th>
					<th>Publish Date</th>
					<th>Artist</th>
					<th>Genre</th>
					<th>Listening price</th>
				<th>Download price</th>
					<th></th>
				  </tr>';
	$count=0;		  
		foreach($data1 as $tempdata){
	$data2 = $conn->query("SELECT song.id as song_id, song.name as song_name, song.creator_username, song.genre_id, song.publishing_date, song.listening_price, song.download_price, genre.name FROM public.song inner join public.genre on song.genre_id=genre.id WHERE '$tempdata[song_id]'=song.id");
	$count+=1;
	foreach($data2 as $tempdata2){
		echo '<tr>';
				echo '<td class="photo"><img src="images/song_images/';
            echo $tempdata2['song_id'].'.png';
            echo'" style="max-width: 50pt;"></img></td>
					<td>' .$tempdata2['song_name']. '</td>
					<td>' .$tempdata2['publishing_date']. '</td>
					<td>' .$tempdata2['creator_username']. '</td>
					<td>' .$tempdata2['name']. '</td>
					<td>' .$tempdata2['listening_price']. '</td>
	<td>' .$tempdata2['download_price']. '</td>
					<td>
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">';
								if($account_type!='visitor'){

                                echo '
                                <form action="album_playlist_profile.php" method="post">
									<input type="hidden" name="searched" value="'.$search.'">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
									<input type="hidden" name="download_price" value="'.$tempdata2['download_price'].'">
									<input type="hidden" name="listening_price" value="'.$tempdata2['listening_price'].'">
									<input type="hidden" name="isDownload" value="0">
									<input type="hidden" name="albumpl" value="'.$albumpl.'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play</button></a>
                                </form>';}

								echo '
                                <form action="album_playlist_profile.php" method="post">
								<input type="hidden" name="searched" value="'.$search.'">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="isTeaser" value="1">
									<input type="hidden" name="albumpl" value="'.$albumpl.'">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play Teaser</button></a>
                                </form>';
								
								if($account_type!='visitor'){
									
											echo '
                                <form action="album_playlist_profile.php" method="post">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="download_price" value="'.$tempdata2['download_price'].'">
									<input type="hidden" name="listening_price" value="'.$tempdata2['listening_price'].'">
									<input type="hidden" name="isDownload" value="1">
									<input type="hidden" name="albumpl" value="'.$albumpl.'">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Download</button></a>
                                </form>';
										}

								
								if($account_type=='moderator' or $tempdata2['creator_username'] == $curusername){
								echo '<form action="edit_song.php" method="post">
								<input type="hidden" value="'.$tempdata2['song_id'].'" name="searchedsong">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Edit</button></a>
								</form>';}
							echo '</div>
						</div
					></td>
				  </tr>';
		}
		}
		echo '</table><br>';
	}
	catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}
	
	
	
        echo '</section>
            </div>
			<div>';
			
			if(isset($playingSong) && !empty($playingSong)){
	try {
	$queryw0 = "Select is_downloaded from user_song where song_id='$playingSong' and username='$curusername'";
	$dataw0=$conn->query($queryw0);	


		foreach($dataw0 as $tempw0){
		if($isDownload==1 && $tempw0['is_downloaded']==false){
					
			$queryw1 = "select * from deduct_credit('$download_price', '$curusername')";
			if(!$conn->query($queryw1)){
				$poor = false;
			} else $poor=true;
			
			$queryw2 = "update user_song set is_downloaded=true where song_id='$playingSong' and username='$curusername'";
			$conn->query($queryw2);

		}
		else if($isDownload!=1 && $tempw0['is_downloaded']==false){
			$queryw1 = "select * from deduct_credit('$listening_price', '$curusername')";
			if(!($conn->query($queryw1))){
				$poor = false;
			} else $poor=true;
		}
		else $poor=1;
	}
	}
catch(PDOException $e)
{
	echo "Creation failed: " . $e->getMessage();
}
	}
			
			if(!empty($playingSong) && $poor!=0){
	date_default_timezone_set("Europe/Sofia");
	$date = date('Y-m-d h:i:s', time());
	
	try {
		
	$query12 = "INSERT INTO user_listened_to_song (username, song_id, date_time) values ('$curusername', '$playingSong', '$date')";
		$conn->query($query12);
	
	
	$query112 = "select count(song_id) as num from user_song where song_id='$playingSong' and username='$curusername'";
    $kvo=$conn->query($query112);
	foreach($kvo as $t112){
		if($t112['num']==0){
			$query113 = "INSERT INTO user_song (username, song_id) values ('$curusername', '$playingSong')";
    $conn->query($query113);	
		}
	}
    }

	
    catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
   	}
	
    
		}
			
			   if(!empty($playingSong) && $poor!=true){
	

    echo  '<div class="audiocontrols" style="width:250pt;position:absolute;top:65%;left:0.1%;background-color:#e2e2e2;border-top-right-radius: 25px;border-top-left-radius: 25px;border-bottom-right-radius: 25px;border-bottom-left-radius: 25px;">
        <audio controls autoplay style="width:250pt;">';
		if(empty($isTeaser) or !isset($isTeaser)){
        echo '<source src="/songs/'.$playingSong.'.mp3" type="audio/mpeg">';
		}
		else{
		echo '<source src="/songs/'.$playingSong.'_teaser.mp3" type="audio/mpeg">';
		}
		echo'
        </audio>';
		
		if($account_type!='visitor'){echo'
		<div style="width:90%;margin-top:10pt;height:40pt;position:relative;left:5%;background-color:#e2e2e2;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">
        
		<form action="album_playlist_profile.php" method="post" style="width:50%;float:left;">
		<input type="hidden" name="ratedSong" value="'.$playingSong.'">
		<input type="hidden" name="isLike" value="1">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="albumpl" value="'.$albumpl.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
		<button class="likbtn" type="submit" name="submit" style="border: 2pt solid #90ee90;color:black;width:80%;height:30pt;position:relative;left:10%;background-color:#90ee90;border-top-left-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">Like</button>
		</form>
		
		<form action="album_playlist_profile.php" method="post" style="width:50%;float:right;">
		<input type="hidden" name="ratedSong" value="'.$playingSong.'">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="albumpl" value="'.$albumpl.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
		<button class="disbtn" type="submit" name="submit" style="border:2pt solid #ff8989;color:black;width:80%;height:30pt;float:right;position:relative;right:10%;background-color:#ff8989;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">Dislike</button>
		</form>';
		
		try{
	$query20 = "Select count(*) as num from user_song where song_id='$playingSong' and rating!=0";
	$query21 = "Select count(*) as rate from user_song where song_id='$playingSong' and rating!=(-1) and rating!=0";
    $data20=$conn->query($query20);	
	$data21=$conn->query($query21);
	}
	catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
   	}
	
	foreach($data21 as $temp21){
		$rate = $temp21['rate'];break;
	}
	
	foreach($data20 as $temp20){
		$rating = ($rate/$temp20['num'])*100;
		if($rating>=0){
	echo'
		</div>
		<div style="width:90%;position:relative;left:5%;background-color:red;height:20pt;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;border-top-left-radius: 25px;">
		<div style="width:'.$rating.'%;position:relative;background-color:green;height:20pt;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;border-top-left-radius: 25px;"></div>
		</div>
		<p style="color:black;text-align:center;">Rating: '.round($rating).'% out of '.$temp20['num'].' votes</p>';break;
	}
	else echo'<p style="color:black;text-align:center;">No votes submitted, no visible rating.</p></div><br>';
	}
	
		echo'
		<img style="width:50%;margin-left:25%;" src="/images/song_images/'.$playingSong.'.png">
		<p style="margin:1pt;color:black;text-align:center;">Now playing '.$NameplayingSong.' by '.$ArtistplayingSong.' ('.$playingSong.'.mp3)</p>
	</div>';
		}
		else {
			echo'
		<div style="width:90%;margin-top:10pt;height:40pt;position:relative;left:5%;background-color:#e2e2e2;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">	
		<p style="margin:1pt;color:black;text-align:center;">Now playing '.$NameplayingSong.' by '.$ArtistplayingSong.' ('.$playingSong.'.mp3)</p>
	</div>';
		}
}

if(isset($ratedSong) && !empty($ratedSong)){
	
	try{
	if($isLike==1){$query19 = "UPDATE user_song SET rating='1' where song_id='$ratedSong' and username='$curusername'";
    $conn->query($query19);	
	}
	else{
		$query19 = "UPDATE user_song SET rating='-1' where song_id='$ratedSong' and username='$curusername'";
    $conn->query($query19);	
	}
	}
	catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
}}
	
			if($account_type=='visitor'){
                echo'
         <footer style="position:relative;margin-top:100pt;">

             	<a href="register.php" class="footb">Register</a>
             	<a href="login.php" class="footb">Log in</a>
        	<a href="about_us.php"  class="footb">About us</a>
		<a href="subscriptions.php" class="footb">Subscriptions</a>
    </footer>';
            }
            elseif($account_type=='listener' || $account_type=='premium_listener'){
                echo'
         <footer style="position:relative;margin-top:100pt;">
             <a href="subscriptions.php" class="footb">Subscriptions</a>
             <a href="change_sub.php" class="footb">Become creator</a>
        <a href="about_us.php" class="footb">About us</a>
    </footer>';
            }
            elseif($account_type=='creator'){
                echo'
         <footer style="position:relative;margin-top:100pt;">
             <a href="subscriptions.php" class="footb">Subscriptions</a>
        <a href="about_us.php" class="footb">About us</a>
    </footer>';
            }
            else{
            }
			echo'
            </div>
    </body>

</html>';


$_SESSION['account_type'] = $account_type;
?>
