<?php
    $username=$_POST['username'];
    $shrimp=$_POST['shrimp'];
    $abalone=$_POST['abalone'];
    $Chinese_cabbage=$_POST['Chinese_cabbage'];
    $lamb_chop=$_POST['lamb_chop'];
    $bitter_gourd=$_POST['bitter_gourd'];
    $green_salad=$_POST['green_salad'];
    $mutton_soup=$_POST['mutton_soup'];
	$servername = "39.107.39.25";//mysql服务器地址
	$mysqluser = "root";//mysql账户名
	$mysqlpwd = "acEI3iEqsJEEsXQQ";//mysql密码
    $dbname = "CPTJ";//数据库名
    $zero=array();
    $one=array();
    $success=array();
    
    //1 烤虾
    if($shrimp=="0"){
        $zero[]='shrimp';
    }elseif ($shrimp=="1") {
        $one[]='shrimp';
    }
    //2 鲍鱼
    if($abalone=="0"){
        $zero[]='abalone';
    }elseif ($abalone=="1") {
        $one[]='abalone';
    }
    //3 炒白菜
    if($Chinese_cabbage=="0"){
        $zero[]='Chinese_cabbage';
    }elseif ($Chinese_cabbage=="1") {
        $one[]='Chinese_cabbage';
    }
    //4 羊排
    if($lamb_chop=="0"){
        $zero[]='lamb_chop';
    }elseif ($lamb_chop=="1") {
        $one[]='lamb_chop';
    }
    //5 苦瓜汤
    if($bitter_gourd=="0"){
        $zero[]='bitter_gourd';
    }elseif ($bitter_gourd=="1") {
        $one[]='bitter_gourd';
    }
    //6 蔬菜沙拉
    if($green_salad=="0"){
        $zero[]='green_salad';
    }elseif ($green_salad=="1") {
        $one[]='green_salad';
    }
    //7 羊肉汤
    if($mutton_soup=="0"){
        $zero[]='mutton_soup';
    }elseif ($mutton_soup=="1") {
        $one[]='mutton_soup';
    }
    $conn = mysqli_connect($servername, $mysqluser, $mysqlpwd, $dbname);
	if ($conn) {
        if(!empty($zero)){
            $sql1="update `like` set ";
            for ($i=0; $i < sizeof($zero)-1; $i++) { 
                $sql1=$sql1.$zero[$i]."=".$zero[$i]."+2.0,";
            }
            $sql1=$sql1.end($zero)."=".end($zero)."+2.0 where username='$username'";
            if($conn->query($sql1)){
                $success['zeroCode'] = 0;
            }else{
                $success['zeroCode'] = 1;
            }
        }else{
            $success['zeroCode'] = 2;
        }         
        if(!empty($one)){
            $sql2="update `like` set ";
            for ($i=0; $i < sizeof($one)-1; $i++) { 
                $sql2=$sql2.$one[$i]."=".$one[$i]."-2.0,";
            }
            $sql2=$sql2.end($one)."=".end($one)."-2.0 where username='$username'";
            if($conn->query($sql2)){
                $success['oneCode'] = 0;
            }else{
                $success['oneCode'] = 1;
            }
        }else{
                $success['oneCode'] = 2;
        }
    }else{
        $success['msg']='NO';
        $success['infoCode'] = 3;
    }
    //infoCode: 3连接不成功，2数据小于-10或>10
    //oneCode:0成功，1失败
    echo json_encode($success);
?>