<?php
//<!-- Animate.css -->
include($_SERVER['DOCUMENT_ROOT']."/bash/init.php");

function is_duplicate_name($username){
        global $conn;

        $username = mysqli_real_escape_string($conn, $username);
        $query = sprintf("SELECT username FROM applicant where username='%s'",
                        $username);
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_array($result);
        if($data == NULL){    
            return False;
        }else{
            return True;
        }

        
}
function add_new_user($username, $password){
        global $conn;
        $password = hash("sha512" , mysqli_real_escape_string($conn, $password));
        $username = mysqli_real_escape_string($conn, $username);
        $query = sprintf("INSERT INTO applicant (username, password) VALUE ('%s' ,'%s');",
                $username, $password);
        mysqli_query($conn, $query);
}
function check_name($username , $is_sign){
    if(!is_resource($conn)){
       // include "Error.html";
    }else{
        //magin quoter check .. for security
        if(get_magic_quotes_gpc()){
            $username = stripslashes($_REQUEST['nick']);
        }else{
            $username = $_REQUEST['nick'];
        }
        
        if(is_duplicate_name($username) == False && $is_sign == True){
            add_new_user($username);
        }

        if(mysql_affected_rows($conn) > 0){
            echo "Product Inserted\n";
        }
    }
    return $result; 
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Wirte</title>
<style>
body{
    background : black;
    color : white;
    font-size: 16px;
}
div{
    width : 310px;
    height : 80px;
    top : 50%;
    left : 50%;
    margin-top : -80px;
    margin-left : -155px;
    position : absolute;
    text-decoration: none;

}
form
{
    border : 5px;
}
form > label {
    display:block;
    margin-bottom: 10px;
}
form > label > span{
    display: inline-block;
    float: left;
}
form > label > input 
{
    background: transparent;
    border: none;
    color : white;
    border-bottom: 1px solid #7e7e7e;
    outline: none;
    padding: 0px 15px 0px 0px;
    font-size : 23px;
}
form > label > input:focus{
    border-bottom: 1px solid #D9FFA9;
}

.button {
    background-color: #555555;
    float: left;
    display: inline-block;
    width : 190px;
    height : 50px;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    cursor:pointer; 
    top : 70%;
    left : 50%;
    margin-left : 45px;
}
::-moz-selection {
   background-color: #317572;
   color: #fff;
}
::selection {
    background-color: #317572;
    color: #fff;
}

</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript">
//auto expand textarea
function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}

$(document).ready(function(){
    $("#check").click(function(){
        var name = $("#nick").val();
        var is_first = False;

        //check sing up to checkbox
        if(documnet.getElementById("is_first").checked){
            is_first = True;
        }

        $.get("./enter.php" , { nick : name ,  signup : is_first })
            .done( function(result){
                if( result == 1 ){
                    //is True 
                    $("#check").text("login");
                    $("p").text( "Ok, All ready");
                }else{
                    //is False
                    $("#check").text("login");
                    $("p").text( "Ok, All ready");

                }
        });
    });
});
</script>
</head>
<body>
<div>
    <form method="POST">
        <label for="name">
            <span>Enter Your Name</span><br>
            <input type="text" id="nick" name="username" required="true" />
        </label>
        <label style="" for="sexy">
            <span>Enter Password</span><br>
            <input type="password" name="password" />
        </label>
        <input id="is_first"style="display:inline-block" type="checkbox" name="signup" value="true">Sign up</input> 
    <a style="display:block;margin:15px"id="a_btn" href="resume/write.php"><button type="submit" id="check" name="login"class="button">Login</button></a>
    <?php 
        $msg = '';

        //Sign up
        if(isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])){ 
            $username = $_POST['username'];
            $password = $_POST['password'];

            //Sign up
            if(isset($_POST['signup']) && $_POST['signup'] == True){
                if(is_duplicate_name($username) == False){
                    add_new_user($username , $password);
                    $msg = "Sign up successful.";
                }else{
                    $msg = "id is dupliccated.";
                }
            //Sgin in
            }else{
                $username = mysqli_real_escape_string($conn, $username);
                $password = hash("sha512", mysqli_real_escape_string($conn, $password));
                $query = sprintf("SELECT username FROM applicant where username='%s' and password='%s'",
                                $username, $password);
                $data = mysqli_fetch_array(mysqli_query($conn, $query));
                if( $data != NULL &&  $data['username'] === $username){
                    //login success
                    //session_start();
                    $_SESSION['username'] = $username;
                    if(isset($_SESSION['username'])){
                        $msg = $_SESSION['username'];
                        //header('Location: resume/');
                        $msg = "<script> alert('hello $msg'); window.location='http://rm-rf.life/bash/';</script>";
                        //$msg = $_SESSION['username']."FUCK". session_id();
                        //exit();
                        }
                }else{
                    $msg = 'wrong password or id';
                }
            }
        }
    ?>
    <p style="display:inline-block;text-align:center;"><?php echo $msg; ?></p>
    </form>
</div>
</body>
</html>

