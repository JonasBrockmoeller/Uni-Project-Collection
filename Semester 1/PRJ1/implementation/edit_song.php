<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);
include_once('dbconnect.php');
include_once('mp3trim.php');

//css
echo '<html><head>
<title>Edit song</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<link rel="stylesheet" href="/css/register.css">';

//store the output of the form of the homepage

$account_type = $_SESSION['account_type'];

$_SESSION['searchedsong'] = $_POST['searchedsong'];
$searchedsong = $_SESSION['searchedsong'];

//store the output of the current form
$_SESSION['genreid'] = $_POST['genreid'];
$genreid = $_SESSION['genreid'];

$_SESSION['songname'] = $_POST['songname'];
$newsongname = $_SESSION['songname'];

$_SESSION['genrename'] = $_POST['genrename'];
$newgenrename = $_SESSION['genrename'];

$_SESSION['listenprice'] = $_POST['listenprice'];
$newlistenprice = $_SESSION['listenprice'];

$_SESSION['downloadprice']=$_POST['downloadprice'];
$newdownloadprice = $_SESSION['downloadprice'];

$_SESSION['trailer']=$_POST['trailer'];
$newtimestamp = $_SESSION['trailer'];

$_SESSION['delete']=$_POST['delete'];
$delete = $_SESSION['delete'];

if($account_type=='visitor'){
	echo '<meta http-equiv="refresh" content="0;URL=register.php"/> ';
}
else if( $account_type=='visitor'){
	echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
}

try {
$query1 = "SELECT song.length, song.name as song_name, song.genre_id, song.listening_price, song.download_price, song.preview_timestamp, genre.name as genre_name FROM public.song inner join public.genre on song.genre_id=genre.id WHERE song.id=?";
$stmt = $conn->prepare($query1);
$stmt->execute([$searchedsong]);
$data = $stmt->fetchAll();
}

catch(PDOException $e)
{
	echo "Creation failed: " . $e->getMessage();
}
	foreach($data as $temp){

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
        <title>Edit Song</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
<br>
        <aside>

            <img class="asidePic" src="source_images/edit_song.png" style="transform: scaleX(1);pointer-events:none;height:60%;width:auto;position:absolute;left:5%;top:20%;">

        </aside>

        <section>
            <form action="edit_song.php" method="post" enctype="multipart/form-data">
                <div class="container">

                    <a href="homepage.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>


                    <h1>Edit song : '.$temp['song_name'].'</h1>

										<p>Please fill in this form to change song details.</p>
                    <hr>

										<h2>Change the song name:</h2>
                    <input maxlength="75" type="text" placeholder="Song name" name="songname" value="'.$temp['song_name'].'" required>

										<h2>Current thumbnail:</h2>
										<img src="images/song_images/'.$searchedsong.'.png" width="120" height="100">


										<h2>Change the song thumbnail (.png format)</h2>
										<input type="file" name="image_png"><br><br>

										<h2>Select one of the following genres: </h2>
										<h3>Current genre: '.$temp['genre_name'].' <h3>
										<input name="genreid" type="radio" value="1">Rock<br>
										<input name="genreid" type="radio" value="2">Pop<br>
										<input name="genreid" type="radio" value="3">EDM<br>
										<input name="genreid" type="radio" value="4">Hip-Hop<br>
										<input name="genreid" type="radio" value="5">R&B<br>
										<input name="genreid" type="radio" value="6">Latin<br>
										<input name="genreid" type="radio" value="7">Country<br>
										<input name="genreid" type="radio" value="8">House<br>
										<input name="genreid" type="radio" value="9">Christmas<br>
   									<input name="genreid" type="radio" value="10">Hard rock<br>
										<input name="genreid" type="radio" value="11">Lounge<br>
     								<input name="genreid" type="radio" value="12">Electronic<br>
										<input name="genreid" type="radio" value="13">Metal<br>
										<input name="genreid" type="radio" value="14">Folk<br>
										<input name="genreid" type="radio" value="15">Pop-folk<br>
      							<input name="genreid" type="radio" value="16">Christian<br>
										<input name="genreid" type="radio" value="17">Disco<br>
										<input name="genreid" type="radio" value="18">Soul<br>
                		<input name="genreid" type="radio" value="19">Funk<br>
										<input name="genreid" type="radio" value="20">Jazz<br>
										<input name="genreid" type="radio" value="21">Classical<br>
										<input name="genreid" type="radio" value="22">Ska<br>
          					<input name="genreid" type="radio" value="23">Reggae<br><br>

										<h2>Other song details</h2>

					<br><label for="listenprice" style="margin-right:10pt;"> Listening price </label>
					<input max="3" min="0.1" type="number" name="listenprice" value="'.$temp['listening_price'].'" required><br>

					<br><label for="downloadprice" style="margin-right:10pt;"> Download price </label>
					<input max="3" min="0.1" type="number" name="downloadprice" value="'.$temp['download_price'].'" required><br>

					<br><label for="trailer" style="margin-right:10pt;"> Trailer timestamp </label>
					<input max="'.$temp['length'].'" min="0" type="number" name="trailer" value="'.$temp['preview_timestamp'].'" required><br><br><br>

					<input type = "hidden" name="searchedsong" value = "'.$searchedsong.'">

					<input type="checkbox" id="box" name="delete" value="true">
					<label for="box">Check this box to delete the song after submission.</label><br>

					<br><br><input type="checkbox" id="boxx" required>
					<label for="boxx">Are you sure that you want to edit this song?</label><br>

                    <br><button type="submit" name="Submit" class="registerbtn">Save & Apply</button>					</form>';break;
	}


	if(isset($_POST["Submit"]))
	{
		$imagetmp = $_FILES["image_png"]["tmp_name"];
		var_dump($_FILES["image_png"]["tmp_name"]);
    $imagepath = $_FILES["image_png"]["name"];
    $exte = pathinfo($imagepath, PATHINFO_EXTENSION);
    $filepath = "images/song_images/".$searchedsong.".png";

      if($exte == 'PNG' || $exte == 'png'){
          move_uploaded_file($imagetmp,$filepath);
          echo"<br>Successfully entered song image.";
      }else{
        echo "<br>Error: Entered file's format was ".$exte.". It should have been png. Please try again.<br>";
      }


	if($genreid != null){
	try {
	$query2 = "UPDATE song SET name = ?, genre_id = ?, listening_price = ?, download_price = ?, preview_timestamp = ? WHERE id = ?";
	$stmt = $conn->prepare($query2);
	$stmt->execute([$newsongname, $genreid, $newlistenprice, $newdownloadprice, $newtimestamp, $searchedsong]);
	}
	catch(PDOException $e)
	{
	echo "Creation failed: " . $e->getMessage();
  }
 }


 elseif($genreid == null){
 try {
 $query2 = "UPDATE song SET name = ?, listening_price = ?, download_price = ?, preview_timestamp = ? WHERE id = ?";
 $stmt = $conn->prepare($query2);
 $stmt->execute([$newsongname, $newlistenprice, $newdownloadprice, $newtimestamp, $searchedsong]);
 }
 catch(PDOException $e)
 {
 echo "Creation failed: " . $e->getMessage();
	}
 }


 if($newtimestamp != null){
	 //Creating a new teaser based on form input
	 $mp3input = 'songs/'.$searchedsong.'.mp3';
	 $teasername = 'songs/'.$searchedsong.'_teaser.mp3';

	 $mp3 = new PHPMP3($mp3input);
	 $mp3_1 = $mp3->extract($newtimestamp,30);
	 $mp3_1->save($teasername);
 }


	if($delete != null){
	try {
	$query3 = "DELETE FROM song WHERE id = ?";
	$stmt = $conn->prepare($query3);
	$stmt->execute([$searchedsong]);
	}
	catch(PDOException $e)
	{
	echo "Creation failed: " . $e->getMessage();
	}
	$delsongpath = "songs/".$searchedsong.".mp3";
	$delthumbnailpath = "images/song_images/".$searchedsong.".png";
	unlink($delsongpath);
	unlink($delthumbnailpath);
	}


echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
}

?>
