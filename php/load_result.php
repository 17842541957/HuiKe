<?php
    $user = $_POST["user"];
    $servername = "39.107.39.25";//mysql服务器地址
	$mysqluser = "root";//mysql账户名
	$mysqlpwd = "acEI3iEqsJEEsXQQ";//mysql密码
    $dbname = "CPTJ";//数据库名
    $sql = "select result from img where username='$user'";//sql语句
    $success = array('msg'=>'OK');
	//创建连接
	$conn = mysqli_connect($servername, $mysqluser, $mysqlpwd, $dbname);
	if ($conn) {
        mysqli_query($conn,'set names utf8');
        mysqli_query($conn,'set character_set_client=utf8');
        mysqli_query($conn,'set character_set_results=utf8');

        $result = $conn->query($sql);
        if($result->num_rows>0){
            while($rows = mysqli_fetch_assoc($result)){
                $success["code"]=$rows["result"]; 
            }
            $sql2="";
            if ($success["code"]=='0') {
                $sql2="update `like` set bitter_gourd=bitter_gourd+0.1 where username='$user'";
            }
            if ($success["code"]=='2') {
                $sql2="update `like` set green_salad=green_salad+0.1 where username='$user'";
            }
            if ($success["code"]=='3') {
                $sql2="update `like` set green_salad=green_salad+0.1,Chinese_cabbage=Chinese_cabbage+0.1 where username='$user'";
            }
            if($sql2!=""){
                if($result = $conn->query($sql2)){
                    $success['infoCode'] = 0;
                }   
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