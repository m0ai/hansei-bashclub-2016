<?php
    include($_SERVER['DOCUMENT_ROOT']."/bash/init.php");

    if(!isset($_SESSION['admin'])){
        echo "<script>window.history.back();</script>";
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
        $query = sprintf("select * from resume where final='1' and idx='%s';", $_GET['idx'] ); 
        
        $result = mysqli_query($conn, $query);
        $restore_value = mysqli_fetch_assoc($result);
        
        //check permission
        if(!isset($_SESSION['admin'])){
            echo "<script>alert('no hack');</script>";
            echo "<script>window.history.back();</script>";
            exit();
        }

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
<div class="box">
<a href="#notice">
<button class="button" href="#notice">Notice and TIP!</button ></a>
</div>
<div id="main">
<form method="post">
<input class="input" type="text" name="username" placeholder="<?= restore("username"); ?>" readonly >
<input class="input" id="" type="text" name="realname" placeholder="realname *" value="<?= restore("realname"); ?>" readonly>
<input class="input" id="email_text" type="email" name="email" placeholder="email *" value="<?= restore("email"); ?>" readonly>
<select class="select"id="job" name="point"readonly>
    <option value="none">yet</option>
    <option value="pwnable">pwnable</option>
    <option value="forensics">forensics</option>
    <option value="reversing">reversing</option>
    <option value="network">network</option>
    <option value="web">web</option>
</select>
<input class="input" id="" type="text" name="title" placeholder="title *" value="<?= restore("title");?>" readonly>
<textarea style="line-height:1.4;"class="textarea"id="main_text" type="text" name="contents" placeholder=""readonly>
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
- 마감은 3/29 24:00:00 까지이며 이후의 제출은 유효하지 않습니다.
- 자신이 공부했던 분야 혹은 사이트가 있다면 랭킹 혹은 점수와 같이 적어주세요
- 웹에서 작성하는 페이지인 만큼 로컬 환경에서 작성 한 후 제출하세요.
- 포부를 확실하게 적어주세요
- 만약 합격하시면 동아리에서 탈퇴시에 엄지손가락과 검지손가락을 자르셔야합니다.
- 학년별 목표와 3년목표를 상세히 적어주시면 감사하겠습니다.
- 사이트에 취약점을 찾아낸다면 가산점이 있습니다.
- 기타 문의사항은 frozenmoai@gmail.com 으로 이메일 주시길 바랍니다.
            </pre>
        </div>
    </div>
</div>
<script>
</script>
</body>
</html>
