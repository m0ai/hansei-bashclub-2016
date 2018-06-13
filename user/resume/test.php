<?php
    include($_SERVER['DOCUMENT_ROOT']."/bash/init.php");

    if(!isset($_SESSION['username'])){
        header('Location:http://rm-rf/bash');
        exit();
    }
    $username = mysql_res($_SESSION['username']);
    
    function restore($key){
        global $restore_value;
        return $restore_value[$key]; 
    }
    
    //edit mode with idx 
    if(isset($_GET['idx']) && isset($_SESSION['username'])){

        $idx = mysql_res($_GET['idx']);
        $query = sprintf("select * from resume where username='%s' and idx='%s'",
                $username , $idx);
        
        $result = mysqli_query($conn, $query);
        $restore_value = mysqli_fetch_assoc($result);
        
        //check permission
        if($restore_value['username'] !== $_SESSION['username'] ){
            echo "<script>alert('no hack');</script>";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }

    //insert or update loop
    if(isset($_POST['status']) && $_POST['status'] === "save" || isset($_POST['final'])){
        $contents = mysql_res($_POST['contents']);
        $email = mysql_res($_POST['email']);
        $realname = mysql_res($_POST['realname']);
        $title = mysql_res($_POST['title']);
        $special = mysql_res($_POST['point']);

        //
        //update resume query setup  
        //
        
        if(isset($_GET['idx'])){
            $idx =  mysql_res($_GET['idx']);

            $query = sprintf("update resume set realname='%s',email='%s',title='%s',contents='%s',special='%s' where idx='%s';",$realname, $email, $title, $contents,$sepcial,$idx);
            $result = mysqli_query($conn, $query);

            //update final upload 
            if(isset($_POST['final'])){
                $query = "update resume set final='1' where idx='".$idx."'";
                $result = mysqli_query($conn, $query);

                echo "<script>alert('fianl submission success');</script>";
                echo "<script>window.location.replace(\"http://rm-rf.life/bash/user/resume/list.php\");</script>";
            }
            echo "<script>alert('Update success');</script>";
            echo "<script>window.location.replace(\"http://rm-rf.life/bash/user/resume/list.php\");</script>";

        //
        //insert new resume query setup
        //new resume and check private max storage
        //

        }else{
            $query = sprintf("select * from resume where username='%s'", $username );
            $result = mysqli_query($conn, $query);
            $now_resume_count = mysqli_num_rows($result);
            
            //
            //check resume count : MAX is 3
            //
            if($now_resume_count > 3){
                echo "<script>alert('Storage is MAX');</script>";
                echo "<script>window.location.replace(\"http://rm-rf.life/bash/user/resume/list.php\");</script>";
            }else{
                $query = sprintf("insert into resume (username, realname,email, title, contents) values 
                        ('%s', '%s', '%s','%s', '%s');",
                        $username, $realname, $email, $title, $contents );
                $result = mysqli_query($conn, $query);
                header('Location: list.php');
                exit();
            }

        }
    }else{
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>
Write Resume 
</title>
<link rel="stylesheet" type="text/css" href="/bash/css/jejugothic.css">
<link rel="stylesheet" type="text/css" href="/bash/css/bash.css">
<style>
#final{
    border-style:solid;
    border-width:1px;
    border-color:tomato;
}
#final:hover{
    color:tomato;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
<center>
<h1>Write Resume</h1>
</br>
<div class="box">
<a href="#notice">
<button class="button" href="#notice">Notice and TIP!</button ></a>
</div>
</br>
<div id="main">
<form method="post">
<input class="input" type="text" name="username" placeholder="<?php echo $_SESSION['username']; ?>" readonly >
<input class="input" id="" type="text" name="realname" placeholder="realname *" value="<?= restore("realname"); ?>" required>
<input class="input" id="email_text" type="email" name="email" placeholder="email *" value="<?= restore("email"); ?>" required>
<select class="select"id="job" name="point"required>
    <option value="none">yet</option>
    <option value="pwnable">pwnable</option>
    <option value="forensics">forensics</option>
    <option value="reversing">reversing</option>
    <option value="network">network</option>
    <option value="web">web</option>
</select>
<input class="input" id="" type="text" name="title" placeholder="title *" value="<?= restore("title");?>" required>
<textarea style="line-height:1.5"class="textarea"id="main_text" type="text" name="contents" placeholder=""required>
<?= restore("contents");?>
</textarea>
<input type="submit" class="button" name="status" value="save"></br></br>
<?php 
if (isset($_GET['idx'])){
echo '<input type="submit" id="final"class="button" name="final" value="Final Submission">';
}?>
</form>
</div>
</center>
<div id="notice" class="overlay">
    <div class="popup">
        <h2>notice and tip</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <pre class="pre">
- 양식은 자유이며 최종제출하면 수정 할 수 없으니 신중하게 제출 하세요.
- save 버튼을 누르시면 임시 저장되며 최대 3개 까지 저장 하실수 있습니다.
- 임시 저장 한 후 최종제출 하실 수 있습니다. 
- 우리는 당신의 가족사가 궁금하지 않습니다. 
- 마감은 3/7 23:59:59 까지이며 이후의 제출은 유효하지 않습니다.
- 자신이 공부했던 분야 혹은 사이트가 있다면 랭킹 혹은 점수와 같이 적어주세요
- 웹에서 작성하는 페이지인 만큼 로컬 환경에서 작성 한 후 제출하세요.
- 포부를 확실하게 적어주세요
- 만약 합격하시면 동아리에서 탈퇴시에 엄지손가락과 검지손가락을 자르셔야합니다.
- 학년별 목표와 3년목표를 상세히 적어주시면 감사하겠습니다.
- 사이트에 취약점을 찾아낸다면 가산점이 있습니다.
- 기타 문의사항은 bash.hansei@gmail.com 으로 이메일 주시길 바랍니다.
            </pre>
        </div>
    </div>
</div>
<script>
</script>
</body>
</html>
