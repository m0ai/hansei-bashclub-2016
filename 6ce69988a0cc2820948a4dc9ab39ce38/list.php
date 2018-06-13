<?php
    include($_SERVER['DOCUMENT_ROOT']."/bash/init.php");
    
    //check admin 
    if(!isset($_SESSION['admin'])){
        echo "<script>window.history.back();</script>";
        exit();
    }

    $query = "select idx, username, title, email, reg_date from resume where final='1'";
    $result = mysqli_query($conn, $query);

function print_row($row_data){
    if(!empty($row_data)){
        foreach($row_data as $key=>$value){
            echo "<td>".$value."</td>";
        }
        echo "<td><a href='write.php?idx=".$row_data['idx']."'>view</a></td>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/bash/css/bash.css">
<link rel="stylesheet" type="text/css" href="/bash/css/jejugothic.css">
<link rel="stylesheet" type="text/css" href="/bash/css/table.css">
<meta charset="utf-8">
<style>
#new{
background-color : #555555;
height : 40px;
color : white;
font-size:16px;
border:none;
cursor:pointer;
transition:all 0.3s ease-out;
}
#new:hover{
background-color:white;
color : black;
}
</style>
</head>
<body>
<center>
<h1>Write Resume</h1>
<div class="box">
<a href="#notice">
<button class="button" href="#notice">Notice and TIP!</button ></a>
</div>
</br>
<table>
<thead>
<tr>
<th>idx</th>
<th>username</th>
<th>title</th>
<th>email</th>
<th>update</th>
</tr>
</thead>
</tbody>
<?php
while($rows=mysqli_fetch_assoc($result)){
    if(!empty($rows)){
        echo "<tr>";
        print_row($rows);
        echo "</tr>";
    }
}
?>
<tr>
</tr>
</tbody>
</table>
</center>
<a href="write.php" style=""><button id="new"style="width:98%;position:absolute;bottom:0;" >new resume write</button></a>
<div id="notice" class="overlay">
    <div class="popup">
        <h2>NOTICE</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <pre class="pre">
- 꼭 저장을 한 후 최종제출을 눌러주세요.
- 최종 제출을 해야 등록됩니다.
- 아 치킨먹고싶다.
- 임시저장한 데이터는 보지 않습니다. db 관리자는 볼 수도 ?..
- 반드시 실명으로 부탁드립니다. 
- 기타 문의사항은 frozenmoai@gmail.com 으로 이메일 주시길 바랍니다.
            </pre>
        </div>
    </div>
</div>
