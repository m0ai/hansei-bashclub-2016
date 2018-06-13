<?php
session_start();
error_reporting(0);

//Database Connected
$host = "localhost";
$db = "bash";
$sql_id = "root";
$sql_pw = "root";
$conn =mysqli_connect("localhost", $sql_id, $sql_pw, $db);
if($conn->connect_error){
    die('Connect Error (' . $conn->connect_errno . ') '
                . $conn->connect_error);
}

if(isset($_SESSION['admin'])){
    
}else{
//check time 
$start_date = "2016-03-07 00:00:00";
$end_date = "2016-03-09 23:59:59";
if( strtotime($start_date) > time() || strtotime($end_date) < time()){ 
    echo "<script>alert('server closed')</script>";
    echo "<script>window.location.replace(\"http://rm-rf.life/bash\");</script>";
    exit();
}

//check final submit 
$username = mysql_res($_SESSION['username']);
$query = sprintf("select final from resume where username='%s';", $username);
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
if($data['final'] == 1){
    echo "<script>alert('You\'ve already submitted')</script>";
    echo "<script>window.location.replace(\"http://rm-rf.life/bash\");</script>";
    exit();
}
}
function mysql_res($data){
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}
?>
