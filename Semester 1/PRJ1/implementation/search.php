<?php

session_start();
include_once('dbconnect.php');
error_reporting(E_ALL);
ini_set('display_errors',0);

if(isset($_SESSION['email'])){
$emailaddress = $_SESSION['email'];
}
else{
$emailaddress = $_SESSION['email_address'];
}
$password = $_SESSION['password'];

$account_type = $_SESSION['account_type'];

$_SESSION['advsearch']=$_POST['advsearch'];
$advsearch = $_SESSION['advsearch'];

$_SESSION['searched']=$_POST['searched'];
$search = $_SESSION['searched'];

$_SESSION['albumpl']=$_POST['albumpl'];
$albumpl = $_SESSION['albumpl'];

$_SESSION['deleteusername']=$_POST['deleteusername'];
$deleteusername = $_SESSION['deleteusername'];

$_SESSION['searchedemail']=$_POST['searchedemail'];
$searchedemail = $_SESSION['searchedemail'];

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

try{
	$dataw = $conn->query("SELECT username FROM public.account WHERE email='$emailaddress'");
		}
		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}


		foreach($dataw as $tempw){
			$curusername = $tempw['username'];break;}


try{
	$queryw3 = "select credit from payments where account_username='$curusername'";
$dataw3=$conn->query($queryw3);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
foreach($dataw3 as $tempw3){$credit=$tempw3['credit'];break;}

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
						echo'
        <div class="wrap">
	<form action="search.php" method = "post">
 	<div class="search">

        <input type="text" class="searchTerm" placeholder="Type in name of song, album, artist..." name="searched" id="searched">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
									<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
									<input type="hidden" name="isDownload" value="'.$isDownload.'">

	<button type="submit" class="searchButton">

          <p>Search</p>
         </button>

         </div>
	</form>
        </div>

        </div>
    </header>

    <body>

	<aside>
         <!--   <h1>Navigational menu</h1>-->';
	if(isset($emailaddress)){echo "<br>Your email: $emailaddress <br>";
	echo "Your credit currently is: $credit €<br><br>";}
	else{echo "<br>You are not registered.<br>";$account_type=='visitor';}
	echo "<br>You are logged in as:  $account_type <br><br>";


        if($account_type=='listener' || $account_type=='moderator' || $account_type=='premium_listener')echo' <a href="library.php"><button class="button">Library</button></a>';
        if($account_type=='creator' || $account_type=='moderator')echo' <button class="button">Upload</button>';
        echo '</aside>

        <div id="main-wrapper">

        <div id="content">';

	if(isset($search) && !empty($search) )
	{
		echo '
		<form method="post">
   <input type="hidden" value="all" name="advsearch">
   <input type="hidden" value="'.$search.'" name="searched">
   <input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
		<p style="font-size:20pt;float:right;background-color:black;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">You searched for '.$search.'.</p><br>
		<br><br>
		<button class="showmore" type="submit" style="float:right;position:relative;top:-25pt;right:-130pt;margin-top:50pt;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">Refresh search</button><br>
		</form>';


		try {

		$query1 = $conn->query("SELECT COUNT(*) FROM public.song WHERE UPPER(name) like UPPER('%$search%') or UPPER(song.creator_username) like UPPER('%$search%')");
		$data1 = $query1->fetch();
		$data2 = $conn->query("SELECT song.id as song_id, song.name as song_name,
	song.creator_username, song.listening_price, song.download_price, song.genre_id, song.publishing_date, tbl.nr_views,
	genre.name FROM public.song
	left join (select song_id, count(*) as nr_views
	from user_listened_to_song group by song_id) as tbl
	on song.id=tbl.song_id
	inner join public.genre on song.genre_id=genre.id
	WHERE UPPER(song.name) like UPPER('%$search%') or UPPER(song.creator_username) like UPPER('%$search%')
	order by COALESCE(tbl.nr_views, 0) desc;");
		}
		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}



		foreach($data1 as $tempdata1)
		{
		echo '
		<form method="post">
   <input type="hidden" value="song" name="advsearch">
   <input type="hidden" value="'.$search.'" name="searched">
   <input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
									<input type="hidden" name="isDownload" value="'.$isDownload.'">
		<p style="float:right;position:relative;right:-230pt;margin-top:50pt;background-color:black;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">We found '.$tempdata1.' songs.</p>
		<button class="showmore" type="submit" style="float:right;position:relative;right:-230pt;margin-top:50pt;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">>></button>
		</form>';break;
		}
	if($advsearch!='playlist' && $advsearch!='album' && $advsearch!='artist'){
		if($tempdata1>0){echo '		<table class="tbl">
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
				  </tr>';}

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

								if($account_type!='visitor' && $account_type!='inactive user'){

                                echo '
                                <form action="search.php" method="post">
									<input type="hidden" value="all" name="advsearch">
									<input type="hidden" value="'.$search.'" name="searched">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="download_price" value="'.$tempdata2['download_price'].'">
									<input type="hidden" name="listening_price" value="'.$tempdata2['listening_price'].'">
									<input type="hidden" name="isDownload" value="0">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play</button></a>
                                </form>';}

								echo '
                                <form action="search.php" method="post">
								<input type="hidden" value="all" name="advsearch">
								<input type="hidden" value="'.$search.'" name="searched">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">

									<input type="hidden" name="isTeaser" value="1">
									<input type="hidden" name="NameplayingSong" value="'.$tempdata2['song_name'].'">
									<input type="hidden" name="ArtistplayingSong" value="'.$tempdata2['creator_username'].'">
                                    <a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Play Teaser</button></a>
                                </form>';

								if($account_type!='visitor' && $account_type!='inactive user'){

											echo '
                                <form action="search.php" method="post">
                                    <input type="hidden" name="playingSong" value="'.$tempdata2['song_id'].'">
									<input type="hidden" value="all" name="advsearch">
									<input type="hidden" value="'.$search.'" name="searched">
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
		echo '</table>';
	}

		try {

		$data3 = $conn->query("SELECT COUNT(*) as count FROM public.account WHERE UPPER(display_name) like UPPER('%$search%') and account.subscription_id=4");
		if($account_type!="moderator")$data4 = $conn->query("SELECT account.display_name, account.username, account.description, account.email FROM public.account WHERE UPPER(display_name) like UPPER('%$search%') and account.subscription_id=4 order by display_name asc;");
		else $data4 = $conn->query("SELECT account.display_name, account.username, account.description, account.email FROM public.account WHERE UPPER(display_name) like UPPER('%$search%') order by display_name asc;");

		}

		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}

		foreach($data3 as $tempdata3)
		{
		echo '<form method="post">
   <input type="hidden" value="artist" name="advsearch">
   <input type="hidden" value="'.$search.'" name="searched">
   <input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
									<input type="hidden" name="isDownload" value="'.$isDownload.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
   <p style="float:right;position:relative;right:25pt;background-color:black;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">We found '.$tempdata3['count'].' artists.</p>
   <button class="showmore" type="submit" style="float:right;position:relative;margin-top:50pt;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">>></button>
		</form>';break;
		}
	if($advsearch!='playlist' && $advsearch!='album' && $advsearch!='song'){
		if($tempdata3['count']>0){
			echo '		<br><br>'; if($advsearch!='artist'){echo'<hr style="border: 2pt solid #C36F76;position:relative;left:0%;">';}echo'<br><br><table class="tbl">
				  <tr>
					<th class="photo">Photo</th>
					<th>Name</th>
					<th>Username</th>
					<th>Description</th>
					<th></th>
				  </tr>';}

		$count=0;
		foreach($data4 as $tempdata4)
		{
		$count+=1;
		echo '<tr>';
		if($count>5 && $advsearch!='artist'){break;}
				echo '<td class="photo"><img src="/images/profile_pictures/circle_'.$tempdata4['username'].'.png" style="max-width: 50pt;"></img></td>
					<td>' .$tempdata4['display_name']. '</td>
					<td>' .$tempdata4['username']. '</td>
					<td>' .$tempdata4['description']. '</td>
					<td>
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">
								
								<form action="searched_profile_page.php" method="post">
								<input type="hidden" value="'.$tempdata4['email'].'" name="searchedemail">
								<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Visit</button></a>
								</form>';
								if($account_type=='moderator'){echo'
								<form action="search.php" method="post">
								<input type="hidden" value="'.$tempdata4['username'].'" name="deleteusername">
   <input type="hidden" value="'.$search.'" name="searched">
   <input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
									<input type="hidden" name="isDownload" value="'.$isDownload.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Delete</button></a>
								</form>';}
								echo'
							</div>
						</div
					></td>
				  </tr>';
		}
		echo '</table><br>';

	}
		try {

		$data5 = $conn->query("SELECT COUNT(*) as count FROM public.albumplaylist WHERE UPPER(name) like UPPER('%$search%') and albumplaylist.isalbum=true and albumplaylist.ispublic=true ");
		$data6 = $conn->query("SELECT albumplaylist.id, albumplaylist.name, albumplaylist.creator_username, albumplaylist.description FROM public.albumplaylist WHERE UPPER(name) like UPPER('%$search%') and albumplaylist.isalbum=true and albumplaylist.ispublic=true order by name asc;");

		}

		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}

		foreach($data5 as $tempdata5)
		{
		echo '<br><form method="post">
   <input type="hidden" value="album" name="advsearch">
   <input type="hidden" value="'.$search.'" name="searched">
   <input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
									<input type="hidden" name="isDownload" value="'.$isDownload.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
   <p style="float:right;position:relative;right:25pt;background-color:black;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">We found '.$tempdata5['count'].' albums.</p>
		<button class="showmore" type="submit" style="float:right;position:relative;margin-top:50pt;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">>></button>
		</form>';break;
		}
	if($advsearch!='playlist' && $advsearch!='song' && $advsearch!='artist'){
		if($tempdata5['count']>0){echo '		<br><br>'; if($advsearch!='album'){echo'<hr style="border: 2pt solid #C36F76;position:relative;left:0%;">';}echo'<br><br><table class="tbl">
				  <tr>
					<th class="photo">Photo</th>
					<th>Name</th>
					<th>Username</th>
					<th>Description</th>
					<th></th>
				  </tr>';}

		$count=0;
		foreach($data6 as $tempdata6)
		{
		$count+=1;
		echo '<tr>';
		if($count>5 && $advsearch!='album'){break;}
				echo '<td class="photo"><img src="/source_images/profile_icon.png" style="max-width: 50pt;"></img></td>
					<td>' .$tempdata6['name']. '</td>
					<td>' .$tempdata6['creator_username']. '</td>
					<td>' .$tempdata6['description']. '</td>
					<td>
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">
								<a href="#">Play</a>
								<a href="#">Play Teaser</a>
								<form action="album_playlist_profile.php" method="post">
								<input type="hidden" value="'.$tempdata6['id'].'" name="albumpl">
								<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Visit</button></a>
								</form>
							</div>
						</div
					></td>
				  </tr>';
		}
		echo '</table><br>';

	}
		try {

		$data7 = $conn->query("SELECT COUNT(*) as count FROM public.albumplaylist WHERE UPPER(name) like UPPER('%$search%') and albumplaylist.isalbum=false and albumplaylist.ispublic=true");
		$data8 = $conn->query("SELECT albumplaylist.id, albumplaylist.name, albumplaylist.creator_username, albumplaylist.description FROM public.albumplaylist WHERE UPPER(name) like UPPER('%$search%') and albumplaylist.isalbum=false and albumplaylist.ispublic=true order by name asc;");

		}

		catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}

		foreach($data7 as $tempdata7)
		{
		echo '<br><form method="post">
   <input type="hidden" value="playlist" name="advsearch">
   <input type="hidden" value="'.$search.'" name="searched">
   <input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
									<input type="hidden" name="isDownload" value="'.$isDownload.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
   <p style="float:right;position:relative;right:25pt;background-color:black;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">We found '.$tempdata7['count'].' playlists.</p>
		<button class="showmore" type="submit" style="float:right;position:relative;margin-top:50pt;padding:8pt;border: 1pt solid #b79600;border-radius: 25px 25px 25px 25px;">>></button>
		</form>';break;
		}
	if($advsearch!='song' && $advsearch!='album' && $advsearch!='artist'){
		if($tempdata7['count']>0){echo '		<br><br>'; if($advsearch!='playlist'){echo'<hr style="border: 2pt solid #C36F76;position:relative;left:0%;">';}echo'<br><br><table class="tbl">
				  <tr>
					<th class="photo">Photo</th>
					<th>Name</th>
					<th>Username</th>
					<th>Description</th>
					<th></th>
				  </tr>';}

		$count=0;
		foreach($data8 as $tempdata8)
		{
		$count+=1;
		echo '<tr>';
		if($count>5 && $advsearch!='playlist'){break;}
				echo '	  <td class="photo"><img src="/source_images/profile_icon.png" style="max-width: 50pt;"></img></td>
					<td>' .$tempdata8['name']. '</td>
					<td>' .$tempdata8['creator_username']. '</td>
					<td>' .$tempdata8['description']. '</td>
					<td>
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">
								<a href="#">Play</a>
								<a href="#">Play Teaser</a>
								<form action="album_playlist_profile.php" method="post">
								<input type="hidden" value="'.$tempdata8['id'].'" name="albumpl">
								<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Visit</button></a>
								</form>
							</div>
						</div
					></td>
				  </tr>';
		}
		echo '</table><br>';

	}
	}


else{
        echo '<p>Your search was empty.</p>';
}
		if(isset($playingSong) && !empty($playingSong)){
	try {
	$qcheck = "select max(date_time) from user_listened_to_song where username='$curusername' and song_id='$playingSong'";
    $dcheck=$conn->query($qcheck);

	$queryw0 = "Select is_downloaded from user_song where song_id='$playingSong' and username='$curusername'";
	$dataw0=$conn->query($queryw0);


		foreach($dataw0 as $tempw0){
		if($isDownload==1 && $tempw0['is_downloaded']==false){

			$queryw1 = "select * from deduct_credit('$download_price', '$curusername')";
			if(!$conn->query($queryw1)){
				$poor = 0;
			} else $poor=1;

			$queryw2 = "update user_song set is_downloaded=true where song_id='$playingSong' and username='$curusername'";
			$conn->query($queryw2);

		}
		else if($isDownload!=1 && $tempw0['is_downloaded']==false){
			$queryw1 = "select * from deduct_credit('$listening_price', '$curusername')";
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

		}

		if(!empty($playingSong) && $poor!=true){

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

		<form action="search.php" method="post" style="width:50%;float:left;">
		<input type="hidden" value="all" name="advsearch">
   <input type="hidden" value="'.$search.'" name="searched">
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

		<form action="search.php" method="post" style="width:50%;float:left;">
		<input type="hidden" value="all" name="advsearch">
   <input type="hidden" value="'.$search.'" name="searched">
		<input type="hidden" name="ratedSong" value="'.$playingSong.'">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
		<input type="hidden" name="download_price" value="'.$download_price.'">
									<input type="hidden" name="listening_price" value="'.$listening_price.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
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

if(isset($deleteusername) && !empty($deleteusername)){
	$querydel1 = "DELETE FROM user_listened_to_song WHERE username='$deleteusername';";
    $conn->query($querydel1);
	$querydel2 = "DELETE FROM user_song WHERE username='$deleteusername';";
    $conn->query($querydel2);
	$q = "select song.id from song where creator_username='$deleteusername'";
	$d=$conn->query($q);
	foreach($d as $tempd){
		$kp=$tempd['id'];
		$querydel222 = "DELETE FROM user_song WHERE song_id='$kp';";
		$conn->query($querydel222);
		$querydel223 = "DELETE FROM user_listened_to_song WHERE song_id='$kp';";
		$conn->query($querydel223);
	}
	
	$q1 = "select albumplaylist.id from albumplaylist where creator_username='$deleteusername'";
	$d1=$conn->query($q1);
	foreach($d1 as $tempd1){
		$kp1=$tempd1['id'];
		$querydel2222 = "DELETE FROM album_playlist_songs WHERE album_playlist_id='$kp1';";
		$conn->query($querydel2222);
		$querydel2232 = "DELETE FROM albumplaylist WHERE id='$kp1';";
		$conn->query($querydel2232);
	}
	$querydel22 = "DELETE FROM song WHERE creator_username='$deleteusername';";
    $conn->query($querydel22);
	$querydel3 = "DELETE FROM payments WHERE account_username='$deleteusername';";
    $conn->query($querydel3);
	$querydel4 = "DELETE FROM account WHERE username='$deleteusername';";
    $conn->query($querydel4);
	unset($deleteusername);
}

?>
