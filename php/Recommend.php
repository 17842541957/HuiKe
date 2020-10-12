<?php
    $username=$_POST['username'];
    exec("python ../Python/Recommend02.py {$username}",$out,$res);
    echo json_encode($out);
?>