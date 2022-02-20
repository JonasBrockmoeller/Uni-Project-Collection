<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);
include_once('dbconnect.php');
include_once('mp3trim.php');

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

try{
	$queryw3 = "select credit from payments where account_username='$pfpname'";
$dataw3=$conn->query($queryw3);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
foreach($dataw3 as $tempw3){$credit=$tempw3['credit'];break;}


if(!isset($emailaddress)){
  $account_type = "visitor";
}



$filecheck = 'images/profile_pictures/circle_'.$dataU[0].'.png';
echo '<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/newcss.css">
    </head>
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
							<img class="headPr" src="/images/profile_pictures/circle_'.$pfpname.'.png">
						<img class="headPr" src="/images/profile_pictures/circle_'.$pfpname.'.png">
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
    </header>
    <body>
        <div id="main-wrapper">
        <aside>
         <!--   <h1>Navigational menu</h1>-->';
    if($account_type != 'visitor')
    {
        echo "<br>Your email: $emailaddress <br>";
        echo '<br>You are currently a: '.$account_type.'<br><br>';
		echo "Your credit currently is: $credit €<br><br>";
    }
    else{
    echo '<br>You are not registered.<br>';
    echo "You are currently a: $account_type <br><br>";
    }


        if($account_type=='listener' || $account_type=='moderator' || $account_type=='premium_listener')echo' <a href="library.php"><button class="button">Library</button></a>';
        if($account_type=='creator' || $account_type=='moderator')echo' <a href="upload_songs.php"><button class="button">Upload</button></a>';
        echo '</aside>
    <br><br><br><br>
        <div id="content">
        <h1>TOP 10 SONGS ON THE PLATFORM</h1>
        <div class="kon">';
    try {
    $data2 = $conn->query("SELECT song.id as song_id, song.name as song_name,
	song.creator_username,song.listening_price, song.download_price, song.genre_id, song.publishing_date, tbl.nr_views ,
	genre.name FROM public.song
	left join (select song_id, count(*) as nr_views
	from user_listened_to_song group by song_id) as tbl
	on song.id=tbl.song_id
	inner join public.genre on song.genre_id=genre.id

	order by COALESCE(tbl.nr_views, 0) desc;");

    $data3 = $conn->query("SELECT username FROM public.account WHERE email='$emailaddress'");

    }
    catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
    }

    foreach($data3 as $temp3){
            $curusername = $temp3['username'];break;}
    echo '      <table>
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
	if(!empty($length))$length=$tempdata2['length'];
    $count+=1;
    echo '<tr>
                  <td class="photo"><img src="images/song_images/';
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

				echo'
                <td>
                    <div class="dropdown">
                    <button class="dropbtn">>></button>
                        <div class="dropdown-content">';

                                if($account_type!='visitor' && $account_type!='inactive user'){

                                echo '
                                <form action="homepage.php" method="post">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="download_price" value="'.$tempdata2['download_price'].'">
									<input type="hidden" name="listening_price" value="'.$tempdata2['listening_price'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
									<input type="hidden" name="isDownload" value="0">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play</button></a>
                                </form>';}

								echo '
                                <form action="homepage.php" method="post">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="isTeaser" value="1">
									<input type="hidden" name="listening_price" value="0">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play Teaser</button></a>
                                </form>';

								if($account_type!='visitor' && $account_type!='inactive user'){


											echo '
                                <form action="homepage.php" method="post">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="download_price" value="'.$tempdata2['download_price'].'">
									<input type="hidden" name="listening_price" value="'.$tempdata2['listening_price'].'">
									<input type="hidden" name="isDownload" value="1">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Download</button></a>
                                </form>';
										}


                                if($account_type=='moderator' or $tempdata2['creator_username'] == $pfpname){
                                echo '<form action="edit_song.php" method="post">
                                <input type="hidden" value="'.$tempdata2['song_id'].'" name="searchedsong">
                                <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Edit</button></a>
                                </form>';}
                                echo'
                        </div>
                    </div
                ></td>
              </tr>';
        if($count==10){
        break;
        }
    }
	echo '</table></div></div>';
	if(isset($playingSong) && !empty($playingSong)){
	try {
	$qcheck = "select max(date_time) from user_listened_to_song where username='$curusername' and song_id='$playingSong'";
    $dcheck=$conn->query($qcheck);

	$queryw0 = "Select is_downloaded from user_song where song_id='$playingSong' and username='$pfpname'";
	$dataw0=$conn->query($queryw0);


		foreach($dataw0 as $tempw0){
		if($isDownload==1 && $tempw0['is_downloaded']==false){

			$queryw1 = "select * from deduct_credit('$download_price', '$pfpname')";
			if(!$conn->query($queryw1)){
				$poor = 0;
			} else $poor=1;

			$queryw2 = "update user_song set is_downloaded=true where song_id='$playingSong' and username='$pfpname'";
			$conn->query($queryw2);

		}
                          //not downloaded listening price deducted
		else if($isDownload!=1 && $tempw0['is_downloaded']==false){
			$queryw1 = "select * from deduct_credit('$listening_price', '$pfpname')";
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
		if($account_type!='visitor'){
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

		<form action="homepage.php" method="post" style="width:50%;float:left;">
		<input type="hidden" name="ratedSong" value="'.$playingSong.'">
		<input type="hidden" name="isLike" value="1">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
		<button class="likbtn" type="submit" name="submit" style="border: 2pt solid #90ee90;color:black;width:80%;height:30pt;position:relative;left:10%;background-color:#90ee90;border-top-left-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">Like</button>
		</form>

		<form action="homepage.php" method="post" style="width:50%;float:right;">
		<input type="hidden" name="ratedSong" value="'.$playingSong.'">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
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

echo '</div>
            </div>';
            if($account_type=='visitor' || $account_type=='inactive user'){
                echo'
         <footer style="margin-top:500pt;">

             	<a href="register.php" class="footb">Register</a>
             	<a href="login.php" class="footb">Log in</a>
        	<a href="about_us.php"  class="footb">About us</a>
		<a href="subscriptions.php" class="footb">Subscriptions</a>
    </footer>';
            }
            elseif($account_type=='listener' || $account_type=='premium_listener'){
                echo'
         <footer style="margin-top:400pt;">
             <a href="subscriptions.php" class="footb">Subscriptions</a>
             <a href="change_sub.php" class="footb">Become creator</a>
        <a href="about_us.php" class="footb">About us</a>
    </footer>';
            }
            elseif($account_type=='creator'){
                echo'
         <footer style="margin-top:500pt;">
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

?>
