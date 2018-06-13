<?php
session_start();
if(isset($_GET['moaiissocute']) && $_GET['moaiissocute'] == 'true' ){
    $_SESSION['admin'] = 'true';
}
if(isset($_GET['logout'])){
    session_destroy();
    header('Location: /bash');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>
En Cow?</title>
<style>
body{
background : black;
}
pre.cow-body{
    font-size: 18px;
    margin-left: 40px;
    color : white;
    width : 500px;
    height : 250px;
    top : 50%;
    left : 50%;
    margin-top : 15px;
    margin-left : -200px;
    position : absolute;
    text-decoration: none;}
pre.cow {
    font-size: 18px;
    margin-left: 40px;
    color : white;
    width : 500px;
    height : 250px;
    top : 50%;
    left : 50%;
    margin-top : -171px;
    margin-left : -200px;
    position : absolute;
    text-decoration: none;
}
.button {
    background-color: #555555;
    width : 170px;
    height : 50px;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor:pointer; 
    top : 70%;
    left : 50%;
    margin-left : -85px;
    position : absolute;
}
::-moz-selection {
   background-color: #317572;
   color: #fff;
}
::selection {
    background-color: #317572;
    color: #fff;
}
a{
color :gray;
}
</style>
</head>
<body>
<div>
<p style="color:white">server open time : 2016-03-07 00:00:00 ~ 2016-03-09 23:59:59</p>
<?php
if(isset($_SESSION['admin'])){
echo "<h3 style='color:white'>welcome admin</h3>";
echo "<p style='color:gray'><a href='6ce69988a0cc2820948a4dc9ab39ce38/list.php'>Click to applicant resume list</a></p>";
}
if(isset($_SESSION['username'])){
    echo "<p style='color:gray'><a href='?logout='>Logout</a></p>";
}
?>
<pre id="sexycow"class="cow">

_________________________________________
/ Welcome to team bash. We study          \  
| everything helpful to hacking such as   |
| web, system and more. If you wanna join |
| us, draw up a resume and send to us.    | 
| Than, We will review your resume and    |
\ contact to you individually.            /
  ----------------------------------------
</pre>
<pre class="cow-body">
         \   ^__^ 
          \  (oo)\_______
             (__)\       )\/\
                 ||----w |
                 ||     ||
</pre>
</div>
<?php
if(!isset($_SESSION['username'])){
    echo '<a href="user/enter.php"><button class="button">Try to recruit</button></a>';
}else{
    echo '<a href="user/resume/list.php"><button class="button">Write Resume</button></a>';
}
?>
<script type="text/javascript" src="js/TypingText.js">
/****************************************************
* Typing Text script- By Twey @ Dynamic Drive Forums
* Visit Dynamic Drive for this script and more: http://www.dynamicdrive.com
* Please keep this notice intact
****************************************************/
</script>
<script type="text/javascript">
new TypingText(document.getElementById("sexycow"), 20, function(i){ var ar = new Array("\\", "|", "/", "-"); return " " + ar[i.length % ar.length]; });
TypingText.runAll();
</script>
</body>
</html>
