<?php
$host = 'localhost';
$db = 'hospital_checkup';
$user = 'root';
$pass='';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die("connection failed:" . $e->getMessage());
}
?>