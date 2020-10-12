<?php
	$username = $_POST["username"];
	$password = $_POST["password"];
	$servername = "39.107.39.25";//mysql服务器地址
	$mysqluser = "root";//mysql账户名
	$mysqlpwd = "acEI3iEqsJEEsXQQ";//mysql密码
	$dbname = "CPTJ";//数据库名
    $sql ="insert into user values('$username','$password')";//sql语句
    $sql2 ="insert into `like`(username,shrimp,abalone,Chinese_cabbage,lamb_chop,bitter_gourd,green_salad,mutton_soup) values('$username',5,5,5,5,5,5,5)";
    $success = array('msg'=>'OK');
	//创建连接
	$conn = mysqli_connect($servername, $mysqluser, $mysqlpwd, $dbname);
	if ($conn) {
        if($conn->query($sql)){
                $success['infoCode'] = 0;
                if($conn->query($sql2)){
                    $success['infoCode'] = 0;
                }else{
                    $success['infoCode'] = 4;
                }
        }else{
            $success['infoCode'] = 1;
        }
    }else{
        $success['msg']='NO';
        $success['infoCode'] = 2;
    }
    
    echo json_encode($success);
?>