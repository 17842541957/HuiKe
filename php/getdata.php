<?php
    $servername = "39.107.39.25";//mysql服务器地址
	$mysqluser = "root";//mysql账户名
	$mysqlpwd = "acEI3iEqsJEEsXQQ";//mysql密码
	$dbname = "CPTJ";//数据库名
	$sql ="select count(*) from Nutrition";//sql语句
    $success = array('msg'=>'OK');
	//创建连接
    $conn = mysqli_connect($servername, $mysqluser, $mysqlpwd, $dbname);
    if($conn){
        mysqli_query($conn,'set names utf8');
        mysqli_query($conn,'set character_set_client=utf8');
        mysqli_query($conn,'set character_set_results=utf8');
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $success['count']=$row['count(*)'];
            }
        } else {
            $success['count']=0;
        }
    }
    echo json_encode($success);


?>