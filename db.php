<?php

$connect= mysqli_connect("localhost","root","","test_the_cube_shop");//database name
                                            //password
if ($connect->connect_error) {
    die("fail: " . $connect->connect_error);
}
return $connect; 
?>
