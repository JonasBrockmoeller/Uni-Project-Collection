<?php

session_start();
include_once('dbconnect.php');
error_reporting(E_ALL);
ini_set('display_errors',0);

if(isset($_SESSION['email_address'])){
$emailaddress = $_SESSION['email_address'];
}

$password = $_SESSION['password'];
    
$account_type = $_SESSION['account_type'];

$_SESSION['email_address'] = $emailaddress;
$_SESSION['password'] = $password;

$_SESSION['searched']=$_POST['searched'];
$search = $_SESSION['searched'];

$_SESSION['searchedemail']=$_POST['searchedemail'];
$searchedemail = $_SESSION['searchedemail'];

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
        $stmt = $conn->prepare("SELECT username FROM account WHERE email = ?");
        $stmt->execute([$searchedemail]);
        $dataU = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
        echo "Creation failed: " . $e->getMessage();
}
$pfpname = preg_replace('/\s+/', '%20', $dataU[0]);

try {
    $stmt = $conn->prepare("SELECT username FROM account WHERE email = ?");
    $stmt->execute([$emailaddress]);
    $dataU02 = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
    echo "Creation failed: " . $e->getMessage();
}
$myUsername = preg_replace('/\s+/', '%20', $dataU02[0]);
    
	
try{
	$queryw3 = "select credit from payments where account_username='$myUsername'";
$dataw3=$conn->query($queryw3);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
foreach($dataw3 as $tempw3){$credit=$tempw3['credit'];break;}

if(isset($searchedemail) && !empty($searchedemail)){$searchedemail=$_SESSION['searchedemail'];}
else $searchedemail=$emailaddress;

echo '<!DOCTYPE html>
<html>
    <head>
        <title>Profile Page</title>
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
                <img class="headPr" src="/images/profile_pictures/circle_'.$myUsername.'.png">
                <img class="headPr" src="/images/profile_pictures/circle_'.$myUsername.'.png">
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
		echo "Your credit currently is: $credit €<br><br>";
	}
	else{
	echo '<br>You are not registered.<br>';
	$account_type='visitor';
	echo "You are logged in as: $account_type <br><br>";
	}

	try {

	$data1 = $conn->query("SELECT subscription.name FROM public.subscription inner join public.account on subscription.id=account.subscription_id WHERE account.email='$searchedemail'");
	$data11 = $conn->query("SELECT account.username, account.description FROM public.account WHERE account.email='$searchedemail'");
	$dataw = $conn->query("SELECT username FROM public.account WHERE email='$emailaddress'");
		}
		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}
		
		
		foreach($dataw as $tempw){
			$curusername = $tempw['username'];break;}
			
	echo '<br>You are logged in as: '.$account_type.'<br>';


        if($account_type=='listener' || $account_type=='moderator' || $account_type=='premium_listener')echo' <a href="library.php"><button class="button">Library</button></a>';
        if($account_type=='creator' || $account_type=='moderator')echo' <a href="upload_songs.php"><button class="button">Upload</button></a>';
		foreach($data1 as $tempdata1){$searched_account_type=$tempdata1['name'];break;}
        foreach($data11 as $tempdata11){$searched_username=$tempdata11['username'];
		
		echo '</aside>
	<br><br><br><br>

        <div id="content">
		
        <h1>'.$tempdata11['username'].' ('.$searchedemail.')</h1>
		<h2>Subscription type : '.$searched_account_type.'</h2>
		<h4 style="text-align: center;">Description : '.$tempdata11['description'].'</h4>
		<img style="position:relative;top:-150pt;left:75%;width:150pt;" src="/images/profile_pictures/'.$pfpname.'.png">
        ';break;
		}
		
		try {

	$data2 = $conn->query("SELECT song.id as song_id, song.name as song_name, song.creator_username, song.genre_id, song.publishing_date, song.listening_price, song.download_price, genre.name FROM public.song inner join public.genre on song.genre_id=genre.id where song.creator_username='$searched_username' order by song.name desc;");

	}

	catch(PDOException $e)
	{
	echo "Creation failed: " . $e->getMessage();
	}
	if(!empty($data2)){
	echo '		<h4 style="text-align: center;">Songs uploaded by '.$searched_username.'</h4><hr style="width:70%;border: 2pt solid #C36F76;position:relative;left:5%;"><br><br><table class="tbl">
              <tr>
                <th class="photo">Photo</th>
                <th>Title</th>
                <th>Publish Date</th>
                <th>Artist</th>
                <th>Genre</th>
				 <th>Views</th>
				 <th>Listening price</th>
				<th>Download price</th>
                <th></th>
              </tr>';

	$count=0;
	foreach($data2 as $tempdata2)
		{
			$kon=$tempdata2['song_id'];
		$count+=1;
		echo '<tr>';
		if($count>5 && $advsearch!='song'){break;}
            echo '<td class="photo"><img src="images/song_images/';
            echo $tempdata2['song_id'].'.png';
            echo'" style="max-width: 50pt;"></img></td>
					<td>' .$tempdata2['song_name']. '</td>
					<td>' .$tempdata2['publishing_date']. '</td>
					<td>' .$tempdata2['creator_username']. '</td>
					<td>' .$tempdata2['name']. '</td>';
    try {
    $views = $conn->query("SELECT count(*) as views FROM user_listened_to_song where song_id='$kon'");
    }
    catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
    }

			foreach($views as $tempviews){
            $nrviews = $tempviews['views'];
			break;}
			
    echo '<td>' .$nrviews. '</td>
	<td>' .$tempdata2['listening_price']. '</td>
	<td>' .$tempdata2['download_price']. '</td>';
				
				echo'<td>
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">';
							
								if($account_type!='visitor'){

                                echo '
                                <form action="searched_profile_page.php" method="post">
									<input type="hidden" name="searched" value="'.$search.'">
									<input type="hidden" value="'.$searchedemail.'" name="searchedemail">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="download_price" value="'.$tempdata2['download_price'].'">
									<input type="hidden" name="listening_price" value="'.$tempdata2['listening_price'].'">
									<input type="hidden" name="isDownload" value="0">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play</button></a>
                                </form>';}

								echo '
                                <form action="searched_profile_page.php" method="post">
								<input type="hidden" name="searched" value="'.$search.'">
								<input type="hidden" value="'.$searchedemail.'" name="searchedemail">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="isTeaser" value="1">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play Teaser</button></a>
                                </form>';
								
								if($account_type!='visitor'){
									
											echo '
                                <form action="searched_profile_page.php" method="post">
								<input type="hidden" name="searched" value="'.$search.'">
								<input type="hidden" value="'.$searchedemail.'" name="searchedemail">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="download_price" value="'.$tempdata2['download_price'].'">
									<input type="hidden" name="listening_price" value="'.$tempdata2['listening_price'].'">
									<input type="hidden" name="isDownload" value="1">
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
								echo'
							</div>
						</div
					></td>
				  </tr>';
		}
		echo '</table><br><br>';
	}
		
		
		try {
		
		$data6 = $conn->query("SELECT albumplaylist.id, albumplaylist.name, albumplaylist.creator_username, albumplaylist.description FROM public.albumplaylist WHERE creator_username = '$searched_username' and albumplaylist.isalbum=true and albumplaylist.ispublic=true order by name asc;");
		
		}

		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}

	if(!empty($data6)){
		echo '		'; if($advsearch!='album'){echo'<h4 style="text-align: center;">Albums uploaded by '.$searched_username.'</h4><hr style="width:70%;border: 2pt solid #C36F76;position:relative;left:5%;">';}echo'<br><br><table class="tbl">
				  <tr>
					<th class="photo">Photo</th>
					<th>Name</th>
					<th>Username</th>
					<th>Description</th>
					<th></th>
				  </tr>';
		$count=0;
		foreach($data6 as $tempdata6)
		{
		$count+=1;
		echo '<tr>';
				echo '<td class="photo"><img src="/source_images/profile_icon.png" style="max-width: 50pt;"></img></td>
					<td>' .$tempdata6['name']. '</td>
					<td>' .$tempdata6['creator_username']. '</td>
					<td>' .$tempdata6['description']. '</td>
					<td>
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">
								<form action="album_playlist_profile.php" method="post">
								<input type="hidden" value="'.$tempdata6['id'].'" name="albumpl">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Visit</button></a>
								</form>
							</div>
						</div
					></td>
				  </tr>';
		}
		echo '</table><br><br>';
	}
		
		try {
		
		$data16 = $conn->query("SELECT albumplaylist.id, albumplaylist.name, albumplaylist.creator_username, albumplaylist.description FROM public.albumplaylist WHERE creator_username = '$searched_username' and albumplaylist.isalbum=false and albumplaylist.ispublic=true order by name asc;");
		
		}

		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}
		

	if(!empty($data16)){
		echo '		'; if($advsearch!='album'){echo'<h4 style="text-align: center;">Playlists uploaded by '.$searched_username.'</h4><hr style="width:70%;border: 2pt solid #C36F76;position:relative;left:5%;">';}echo'<br><br><table class="tbl">
				  <tr>
					<th class="photo">Photo</th>
					<th>Name</th>
					<th>Username</th>
					<th>Description</th>
					<th></th>
				  </tr>';
		$count=0;
		foreach($data16 as $tempdata16)
		{
		$count+=1;
		echo '<tr>';
				echo '<td class="photo"><img src="/source_images/profile_icon.png" style="max-width: 50pt;"></img></td>
					<td>' .$tempdata16['name']. '</td>
					<td>' .$tempdata16['creator_username']. '</td>
					<td>' .$tempdata16['description']. '</td>
					<td>
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">
								<form action="album_playlist_profile.php" method="post">
								<input type="hidden" value="'.$tempdata16['id'].'" name="albumpl">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Visit</button></a>
								</form>
							</div>
						</div
					></td>
				  </tr>';
		}
		echo '</table><br><br>';
	}
		
		if(isset($playingSong) && !empty($playingSong)){
	try {
	$queryw0 = "Select is_downloaded from user_song where song_id='$playingSong' and username='$myUsername'";
	$dataw0=$conn->query($queryw0);	


		foreach($dataw0 as $tempw0){
		if($isDownload==1 && $tempw0['is_downloaded']==0){
					
			$queryw1 = "select * from deduct_credit('$download_price', '$myUsername')";
			if(!$conn->query($queryw1)){
				$poor = 0;
			} else $poor=1;
			
			$queryw2 = "update user_song set is_downloaded=true where song_id='$playingSong' and username='$myUsername'";
			$conn->query($queryw2);

		}
		else if($isDownload!=1 && $tempw0['is_downloaded']==0){
			$queryw1 = "select * from deduct_credit('$listening_price', '$myUsername')";
			if(!($conn->query($queryw1))){
				$poor = 0;
			} else $poor=1;
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
        
		<form action="searched_profile_page.php" method="post" style="width:50%;float:left;">
		<input type="hidden" name="ratedSong" value="'.$playingSong.'">
		<input type="hidden" name="isLike" value="1">
		<input type="hidden" name="searchedemail" value="'.$searchedemail.'">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
		<button class="likbtn" type="submit" name="submit" style="border: 2pt solid #90ee90;color:black;width:80%;height:30pt;position:relative;left:10%;background-color:#90ee90;border-top-left-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">Like</button>
		</form>
		
		<form action="searched_profile_page.php" method="post" style="width:50%;float:right;">
		<input type="hidden" name="ratedSong" value="'.$playingSong.'">
		<input type="hidden" name="searchedemail" value="'.$searchedemail.'">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
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

echo '</div>
            </div>';
            if($account_type=='visitor'){
                echo'
         <footer style="margin-top:650pt;">

             	<a href="register.php" class="footb">Register</a>
             	<a href="login.php" class="footb">Log in</a>
        	<a href="about_us.php"  class="footb">About us</a>
		<a href="subscriptions.php" class="footb">Subscriptions</a>
    </footer>';
            }
            elseif($account_type=='listener' || $account_type=='premium_listener'){
                echo'
         <footer style="margin-top:650pt;">
             <a href="subscriptions.php" class="footb">Subscriptions</a>
             <a href="change_sub.php" class="footb">Become creator</a>
        <a href="about_us.php" class="footb">About us</a>
    </footer>';
            }
            elseif($account_type=='creator'){
                echo'
         <footer style="margin-top:650pt;">
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
   	}
}
$_SESSION['account_type'] = $account_type;
?>
