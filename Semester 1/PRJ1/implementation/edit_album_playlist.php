<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);
include_once('dbconnect.php');

//css
echo '<html><head>
<title>Edit Album/Playlist</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<link rel="stylesheet" href="/css/edit.css">';

//store the output of the form of the homepage

if(isset($_SESSION['email'])){
$emailaddress = $_SESSION['email'];
} elseif(isset($_SESSION['email_address'])){
$emailaddress = $_SESSION['email_address'];
}

$password = $_SESSION['password'];

$account_type = $_SESSION['account_type'];

$_SESSION['albumpl'] = $_POST['albumpl'];
$albumpl = $_SESSION['albumpl'];

//store the output of the current form

$_SESSION['title'] = $_POST['title'];
$title = $_SESSION['title'];

$_SESSION['ispublic'] = $_POST['ispublic'];
$ispublic = $_SESSION['ispublic'];

$_SESSION['description'] = $_POST['description'];
$description = $_SESSION['description'];

$_SESSION['deleteSong'] = $_POST['deleteSong'];
$deleteSong = $_SESSION['deleteSong'];

if(isset($deleteSong) && !empty($deleteSong)){
	
	try{
	$query3 = "DELETE FROM public.album_playlist_songs WHERE album_playlist_id=? and song_id=?";
    $stmt = $conn->prepare($query3);
    $stmt->execute([$albumpl, $deleteSong]);
	unset($deleteSong);
	}
	catch(PDOException $e)
	{	
	echo "Creation failed: " . $e->getMessage();
	}
	
}

try {
$query1 = "SELECT albumplaylist.id, albumplaylist.name, albumplaylist.creator_username, albumplaylist.description, albumplaylist.isalbum, albumplaylist.ispublic FROM public.albumplaylist WHERE albumplaylist.id=?";
$stmt = $conn->prepare($query1);
$stmt->execute([$albumpl]);
$data = $stmt->fetchAll();

$data1 = $conn->query("SELECT username FROM public.account WHERE email='$emailaddress'");
}

catch(PDOException $e)
{
	echo "Creation failed: " . $e->getMessage();
}
	foreach($data1 as $temp1){$currentuser=$temp['username'];}
		
	foreach($data as $temp){
		
		if($account_type=='visitor'){
			echo '<meta http-equiv="refresh" content="0;URL=register.php"/> ';
		}
		else if( $account_type!='moderator' && $temp['creator_username']!=currentuser){
			echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
		}

//form itself
echo'
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <head>
        <title>Edit Album/Playlist</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
<br>
        <aside>

            <img class="asidePic" src="source_images/edit_song.png" style="transform: scaleX(1);pointer-events:none;height:60%;width:auto;position:absolute;left:5%;top:20%;">

        </aside>

        <section>
            <form action="edit_album_playlist.php" method = "post">
                <div class="container">

                    <a href="homepage.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>

                    ';
					if($temp['isalbum']==true) echo'<h1>Edit album : </h1><h1>'.$temp['name'].'</h1><p>Please fill in this form to change album details.</p>';
					else echo'<h1>Edit playlist : '.$temp['name'].'</h1><p>Please fill in this form to change playlist details.</p>';
                    echo'
                    <hr>

					<label for="title" style="margin:5pt;">Title: </label>
                    <input maxlength="75" type="text" placeholder="Title" name="title" value="'.$temp['name'].'" required><br>
					
					<label for="description" style="margin:5pt;">Description: </label>
					<textarea maxlength="500" style="padding:15px;border: none;background: #f1f1f1;display: flex;align-items: center;width:540pt;height:150pt;border-radius: 15px;" name="description" required>'.$temp['description'].'</textarea>

					';
					if($temp['ispublic']==true){echo'
					<br><input type="checkbox" name="ispublic" value="'.$temp['ispublic'].'" checked>
					<label for="boxx">Make public?</label>';}
					else{echo'
					<br><input type="checkbox" name="ispublic" value="'.$temp['ispublic'].'">
					<label for="boxx">Make public?</label>';}
					echo'
					<input type = "hidden" name="albumpl" value = "'.$albumpl.'">

					<br><br><input type="checkbox" id="boxx" required>
					<label for="boxx"> Are you sure that you want to commit this edit?</label><br>

                    <br><button type="submit" name="submit" class="registerbtn">Save & Apply</button>

					</form>

                </div>

                <div class="container signin">
                    <hr>
					<form method = "post">
					<input type="checkbox" id="box" required>
					<label for="box"> Are you sure that you want to delete '.$temp['name'].'?</label><br><br>

					<button type="submit" class="registerbtn" style="width:200pt;" name="submit">Delete</button>
					</form>
                </div>
				
				';
		
		try{
	$data1 = $conn->query("select song_id from album_playlist_songs where album_playlist_id=$albumpl");
	
		echo '		<br><hr style="width:70%"><br><h2 style="color:#b79600;text-align:center;">Songs in this album<h2><br><table style="width:70%;position:relative;left:15%;border: 2pt solid black;border-collapse: collapse;">
				  <tr style="border: 2pt solid black;border-collapse: collapse;">
					
					<th style="border: 2pt solid black;border-collapse: collapse;">Title</th>
					<th style="border: 2pt solid black;border-collapse: collapse;">Publish Date</th>
					<th style="border: 2pt solid black;border-collapse: collapse;">Artist</th>
					<th style="border: 2pt solid black;border-collapse: collapse;">Genre</th>
					<th style="border: 2pt solid black;border-collapse: collapse;"></th>
				  </tr>';
	  
		foreach($data1 as $tempdata){
			
	$data2 = $conn->query("SELECT song.id as song_id, song.name as song_name, song.creator_username, song.genre_id, song.publishing_date, genre.name FROM public.song inner join public.genre on song.genre_id=genre.id WHERE '$tempdata[song_id]'=song.id");
	
	foreach($data2 as $tempdata2){
		
		echo '<tr style="border: 2pt solid black;border-collapse: collapse;">';
				echo '
					<td style="border: 2pt solid black;border-collapse: collapse;">' .$tempdata2['song_name']. '</td>
					<td style="border: 2pt solid black;border-collapse: collapse;">' .$tempdata2['publishing_date']. '</td>
					<td style="border: 2pt solid black;border-collapse: collapse;">' .$tempdata2['creator_username']. '</td>
					<td style="border: 2pt solid black;border-collapse: collapse;">' .$tempdata2['name']. '</td>
					<td style="border: 2pt solid black;border-collapse: collapse;">
						<div class="dropdown">
						<button class="dropbtn">>></button>
							<div class="dropdown-content">';
								if($account_type=='moderator' or $tempdata2['creator_username'] == $currentuser){
								echo '<form action="edit_song.php" method="post">
								<input type="hidden" value="'.$tempdata2['song_id'].'" name="searchedsong">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Edit song</button></a>
								</form>
								
								<form action="edit_album_playlist.php" method="post">
								<input type = "hidden" name="albumpl" value = "'.$albumpl.'">
								<input type="hidden" value="'.$tempdata2['song_id'].'" name="deleteSong">
								<a><button type="submit" style="background: transparent;border: transparent;min-width:160px;height:30px">Remove song</button></a>
								</form>';
								}
								
							echo '</div>
						</div
					></td>
				  </tr>';
		}
		}
		echo '</table><br><br><br><br><hr>';
	}
	catch(PDOException $e)
		{
		echo "Creation failed: " . $e->getMessage();
		}
	
	
	
        echo '
                </section>
                </body>
                </html>
';break;
	}
	
	if(isset($_POST["submit"]))
	{
	try {
	$query2 = "UPDATE albumplaylist SET name = ?, description = ?, ispublic = ? WHERE id = ?";
	$stmt = $conn->prepare($query2);
	$stmt->execute([$title, $description, $ispublic, $albumpl]);
	

	}

	catch(PDOException $e)
	{
	echo "Creation failed: " . $e->getMessage();
}
echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
}


?>
