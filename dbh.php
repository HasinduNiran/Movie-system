<?php
$serverName="localhost:3308";
$dbUsername="root";
$dbPassword="";
$dbName="movie";

$conn=mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);

if(!$conn){
    die("connection faild :".mysqli_connect_error());
}