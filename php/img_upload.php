<?php
    $user = $_POST["user"];
    $img = $_POST["img"];
    $class = $_POST["class"];
    $time = $_POST["time"];
    $path = '/opt/lampp/htdocs/菜品推荐/userimg';
    $list = array('Code' => 5,'s'=>0,'msg' => 'OK');
    $servername = "39.107.39.25";//mysql服务器地址
	$mysqluser = "root";//mysql账户名
	$mysqlpwd = "acEI3iEqsJEEsXQQ";//mysql密码
    $dbname = "CPTJ";//数据库名
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)){
        $type = $result[2];
        $list['s']=1;
        $new_file = $path."/".$user."/".$class."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file,0777,true);
        }
        $new_file = $new_file.time().".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1],'',$img)))){
            $path_name="../userimg"."/".$user."/".$class."/".time().".{$type}";
            $sql ="insert into img(username,date,path) values('$user','$time','$path_name');";//sql语句
	        //创建连接
	        $conn = mysqli_connect($servername, $mysqluser, $mysqlpwd, $dbname);
	        if ($conn) {
                if($conn->query($sql)){
                        $list['infoCode'] = 0;
                        if($class=="dishes"){
                            $output = exec('python ../Python/vegetable.py');
                            iconv('gbk', 'utf-8', $output);
                            $array = explode(",",$output);
                            $list['result']=$array;
                        }
                        if ($class=="meat") {
                            $output = exec('python ../Python/Meat.py');
                            iconv('gbk', 'utf-8', $output);
                            $array = explode(",",$output);
                            $list['result']=$array;
                        }
                        
                }else{ 
                    $list['infoCode'] = 1;
                }
            }else{
                $list['msg']='NO';
                $list['infoCode'] = 2;
            }
            $list['Code']=0;
            
        }else{
            $list['Code']=1;
        }
    }else{
        $list['Code']=2;
    }

    echo json_encode($list);
?>  