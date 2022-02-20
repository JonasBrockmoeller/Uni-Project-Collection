<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);
include_once('dbconnect.php');
include_once('mp3file.php');
include_once('mp3trim.php');

$publishing_date = date("Y-m-d");

if(isset($_SESSION['email'])){
$emailaddress = $_SESSION['email'];
} elseif(isset($_SESSION['email_address'])){
$emailaddress = $_SESSION['email_address'];
}else{
  echo '<meta http-equiv="refresh" content="0;URL=forbidden.php"/> ';
}

///////////////////////////////////////////////////////

$_SESSION['radio'] = $_POST['radio'];
$radio = $_SESSION['radio'];

$_SESSION['song_name'] = $_POST['song_name'];
$songname = $_SESSION['song_name'];

$_SESSION['listening_price'] = $_POST['listening_price'];
$lprice = $_SESSION['listening_price'];

$_SESSION['download_price'] = $_POST['download_price'];
$dprice = $_SESSION['download_price'];

$_SESSION['preview_timestamp'] = $_POST['preview_timestamp'];
$preview_timestamp = $_SESSION['preview_timestamp'];

$_SESSION['selectalbumaside1'] = $_POST['selectalbumaside1'];
$assignalbumname1 = $_SESSION['selectalbumaside1'];

///////////////////////////////////////////////////////


$_SESSION['album_name'] = $_POST['album_name'];
$albumname = $_SESSION['album_name'];


$_SESSION['album_description'] = $_POST['album_description'];
$albumdescription = $_SESSION['album_description'];

$_SESSION['albumradio'] = $_POST['albumradio'];
$albumradio = $_SESSION['albumradio'];

///////////////////////////////////////////////////////

$_SESSION['selectsong'] = $_POST['selectsong'];
$assignsongname = $_SESSION['selectsong'];

$_SESSION['selectalbum'] = $_POST['selectalbum'];
$assignalbumname = $_SESSION['selectalbum'];

try {
$stmt = $conn->prepare("SELECT username FROM account WHERE email= ?");
$stmt->execute([$emailaddress]);
$data5 = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
try {

$stmt = $conn->prepare("SELECT name FROM song WHERE creator_username= ?");
$stmt->execute([$data5[0]]);
$data3 = $stmt->fetchAll();
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}

try {

$stmt = $conn->prepare("SELECT name FROM albumplaylist WHERE creator_username= ?");
$stmt->execute([$data5[0]]);
$data4 = $stmt->fetchAll();
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}



///////////////////////////////////////////////////////////////////////////////////////////////FORM 1
echo '
<head>
    <title>Home Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/upload_songs.css">
    <link href="https://fonts.googleapis.com/css?family=Sofia" rel="stylesheet">
</head>
<header>

    <a href="homepage.php">
    <img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png">
    <img class="headP" src="/source_images/cap.png">
    </a>
    </header>
<aside>

<form action="upload_songs.php" method="post" enctype="multipart/form-data">
<h2>Upload a song:</h2>
<h3>Select one of the following genres: </h3>
<label class="container">
<input name="radio" type="radio" value="1">Rock<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="2">Pop<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="3">EDM<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="4">Hip-Hop<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="5">R&B<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="6">Latin<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="7">Country<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="8">House<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="9">Christmas<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="10">Hard rock<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="11">Lounge<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="12">Electronic<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="13">Metal<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="14">Folk<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="15">Pop-folk<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="16">Christian<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="17">Disco<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="18">Soul<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="19">Funk<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="20">Jazz<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="21">Classical<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="22">Ska<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="radio" type="radio" value="23">Reggae<br><br>
<span class="checkmark"></span>
</label>

<h3>Song details</h3>
<input type="text" name="song_name" placeholder="song name">

<input type="number" step="any" name="listening_price" min="0.10" max="3.00" placeholder="Listening price">

<input type="number" step="any" name="download_price" min="0.10" max="3.00" placeholder="Download price">

<input type="number" name="preview_timestamp" min="15" max="3000" placeholder="Preview timestamp">

<h3>Select a song (mp3 format)</h3>
    <input type="file" name="file_audio" required><br>
<h3>Select a thumbnail (png format)</h3>
    <input type="file" name="image_png" required>

<h3>Assign this song to an album (optional)</h3>
<select name="selectalbumaside1">
<option disabled selected value> -- Select an album -- </option>';


foreach($data4 as $data){
echo '<option value="'.$data['name'].'">'.$data['name'].'</option>';
}

echo'
</select><br>
<p align = "right">
<button type="submit" name="Submit_1" class="button">Submit</button>
</form>
</aside>';


//////////////////////////////////////////////////////////////////////////////////////// FORM 2
echo'
<aside>
 <form action="upload_songs.php" method="post" enctype="multipart/form-data">
 <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Create an album:</h2>
 <h3>Album details</h3>
<input type="text" name="album_name" placeholder="Album name" required>
<input type="text" name="album_description" placeholder="Album description" required>

<h3>Upload an album thumbnail (png format)</h3>
<input type="file" name="image_png">


<h3>Make album visible to public?</h3>
<label class="container">
<input name="albumradio" type="radio" value="true">Yes<br>
<span class="checkmark"></span>
</label>

<label class="container">
<input name="albumradio" type="radio" value="false">No<br><br>
<span class="checkmark"></span>
</label>

<p align = "center">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="Submit_2" class="button">Submit</button>
 </form>
</aside>';

//////////////////////////////////////////////////////////////////////////////////////////// FORM 3

echo'
<aside>
 <form action="upload_songs.php" method="post">
 <h2>&nbsp;&nbsp;Add an existing song to an album:</h2>
 <h3>Select a song (oldest ones are on top):</h3>
 <select name="selectsong" required>
 <option disabled selected value> -- Select a song -- </option>';


 foreach($data3 as $data){
 echo '<option value="'.$data['name'].'">'.$data['name'].'</option>';
 }

 echo'
 </select><br>
 <h3>Select an album (oldest ones are on top):</h3>
 <select name="selectalbum" required>
 <option disabled selected value> -- Select an album -- </option>';


 foreach($data4 as $data){
 echo '<option value="'.$data['name'].'">'.$data['name'].'</option>';
 }

 echo'
 </select><br>
<p align = "center">
<button type="submit" name="Submit_3" class="button">Submit</button>
 </form>
</aside>';


// song id and file duration, publishing date, teaser + INSERT

if(isset($_POST["Submit_1"]))
{
//

try {
$stmt = $conn->prepare("SELECT id FROM song order by id desc LIMIT 1");
$stmt->execute();
$data1 = $stmt->fetch(PDO::FETCH_NUM);
if(isset($data1[0]) == null){
  $songid = 1;
} else{
  $songid = $data1[0] + 1;
}
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}

try {
$stmt = $conn->prepare("SELECT username FROM account WHERE email = ?");
$stmt->execute([$emailaddress]);
$data2 = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}




$imagetmp = $_FILES["image_png"]["tmp_name"];
$imagepath = $_FILES["image_png"]["name"];
$filepath2 = "images/song_images/".$songid.".png";
move_uploaded_file($imagetmp,$filepath2);
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($finfo, $filepath2);
finfo_close($finfo);
  if($filetype == 'image/png'){
      $succession1 = TRUE;
  }else{
      unlink($filepath2);
      echo "<br>Error: Entered file's format was ".$filetype.". It should have been image/png. Please try again.<br>";
      $succession1 = FALSE;
  }


    $filetmp = $_FILES["file_audio"]["tmp_name"];
    $path = $_FILES["file_audio"]["name"];
    $filepath = "songs/".$songid.".mp3";
    move_uploaded_file($filetmp,$filepath);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($finfo, $filepath);
    finfo_close($finfo);
    if($filetype == 'audio/mpeg'){
        $succession2 = TRUE;
    }else{
        unlink($filepath);
        echo "<br>Error: Entered file's format was ".$filetype.". It should have been audio/mpeg. Please try again.<br>";
        $succession2 = FALSE;
    }

    if ($succession1 == TRUE && $succession2 == TRUE) //checks if uploaded file is png or not
    {

          $mp3file = new MP3File($filepath);
          $duration2 = $mp3file->getDuration();
          if($duration2>=30 && $duration2<=3000){
      	  move_uploaded_file($filetmp,$filepath);
          echo "<br>Successfully entered song.";

          try {
          $query3 = "INSERT INTO song (creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, publishing_date) values(?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($query3);
          $stmt->execute([$data2[0], $radio, $songname, $duration2, $lprice, $dprice, $preview_timestamp, $publishing_date]);
          }

          catch(PDOException $e)
          {
          echo "Creation failed: " . $e->getMessage();
          }

          if(isset($assignalbumname1)){

            try {

            $stmt = $conn->prepare("SELECT id FROM albumplaylist WHERE name= ? AND creator_username=? ORDER BY id asc");
            $stmt->execute([$assignalbumname1, $data5[0]]);
            $data9 = $stmt->fetch(PDO::FETCH_NUM);
            }

            catch(PDOException $e)
            {
            echo "Creation failed: " . $e->getMessage();
            }

            try {
            $query6 = "INSERT INTO album_playlist_songs (album_playlist_id, song_id) values(?, ?)";
            $stmt = $conn->prepare($query6);
            $stmt->execute([$data9[0], $songid]);
            }

            catch(PDOException $e)
            {
            echo "Creation failed: " . $e->getMessage();
            }
          }

          //Creating a teaser based on form 1 input

          $mp3input = 'songs/'.$songid.'.mp3';
          $teasername = 'songs/'.$songid.'_teaser.mp3';

          $mp3 = new PHPMP3($mp3input);
          $mp3_1 = $mp3->extract($preview_timestamp,30);
          $mp3_1->save($teasername);

          echo"<br>Successfully uploaded song image.";
          echo"<br>Successfully uploaded song audio.";

        } elseif($duration2<30){
          echo"<br>Error: the song's length is too short. It must be 30 seconds at minimum. The uploaded song was ".$duration2." seconds long.";
        }elseif($duration2>3000){
          echo"<br>Error: the song's length is too long. It can be 50 minutes at maximum. The uploaded song was ".$duration2." seconds long.";
        }
    }elseif($succession1 == TRUE && $succession2 == FALSE){
      unlink($filepath2);
    }elseif($succession1 == FALSE && $succession2 == TRUE){
      unlink($filepath);
    }else{

    }


}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if(isset($_POST["Submit_2"]))
{
          try {
          $stmt = $conn->prepare("SELECT id FROM albumplaylist order by id desc LIMIT 1");
          $stmt->execute();
          $data11 = $stmt->fetch(PDO::FETCH_NUM);
          if(isset($data11[0]) == null){
            $albumid = 1;
          } else{
            $albumid = $data11[0] + 1;
          }
          }
          catch(PDOException $e)
          {
          echo "Creation failed: " . $e->getMessage();
          }

          try {
          $stmt = $conn->prepare("SELECT username FROM account WHERE email = ?");
          $stmt->execute([$emailaddress]);
          $data2 = $stmt->fetch(PDO::FETCH_NUM);
          }
          catch(PDOException $e)
          {
          echo "Creation failed: " . $e->getMessage();
          }

          $imagetmp = $_FILES["image_png"]["tmp_name"];
          $imagepath = $_FILES["image_png"]["name"];
          $filepath2 = "images/album_images/".$albumid.".png";
          move_uploaded_file($imagetmp,$filepath2);
          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $filetype = finfo_file($finfo, $filepath2);
          finfo_close($finfo);
            if($filetype == 'image/png'){
                echo"<br>Successfully entered song image.";
                $succession = TRUE;
            }else{
                unlink($filepath2);
                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: Entered file's format was ".$filetype.". It should have been image/png. Please try again.<br>";
                $succession = FALSE;
            }

          if($succession == TRUE){
          try {
          $query4 = "INSERT INTO albumplaylist (creator_username, name, description, ispublic, isalbum, publishing_date) values(?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($query4);
          $stmt->execute([$data2[0], $albumname, $albumdescription, $albumradio, "True", $publishing_date]);
          }

          catch(PDOException $e)
          {
          echo "Creation failed: " . $e->getMessage();
          }

          echo '<meta http-equiv="refresh" content="0;URL=redirect.php"/> ';
        }
        else{

        }
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST["Submit_3"]))
{

  try {

  $stmt = $conn->prepare("SELECT id FROM song WHERE name=? AND creator_username=? ORDER BY id asc");
  $stmt->execute([$assignsongname, $data5[0]]);
  $data6 = $stmt->fetch(PDO::FETCH_NUM);
  }

  catch(PDOException $e)
  {
  echo "Creation failed: " . $e->getMessage();
  }

echo $data6[0];

  try {

  $stmt = $conn->prepare("SELECT id FROM albumplaylist WHERE name= ? AND creator_username=? ORDER BY id asc");
  $stmt->execute([$assignalbumname, $data5[0]]);
  $data7 = $stmt->fetch(PDO::FETCH_NUM);
  }

  catch(PDOException $e)
  {
  echo "Creation failed: " . $e->getMessage();
  }

echo $data7[0];

  try {
  $query5 = "INSERT INTO album_playlist_songs (album_playlist_id, song_id) values(?, ?)";
  $stmt = $conn->prepare($query5);
  $stmt->execute([$data7[0], $data6[0]]);
  }

  catch(PDOException $e)
  {
  echo "Creation failed: " . $e->getMessage();
  }

}
?>
