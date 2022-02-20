<?php
$host = "prj1_postgres";
$port = "5432";
$db = "postgres";
$user = "postgres";
$pword = "mypassword";
$dsn = "pgsql:host=$host;
        port=$port;
        dbname=$db;
        user=$user;
        password=$pword";

try{ // if the connection doesn’t work do not exit but go to catch part
$conn = new PDO($dsn);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*if($conn){
echo "Connected to the <strong>$db</strong> database successfully!";
}*/
}catch (PDOException $e){
// report error message
echo $e->getMessage();
}
?>
