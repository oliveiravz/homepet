<?php

function Conn(){
    $envFile = realpath(dirname(__FILE__) . '/../env.ini');
    $env = parse_ini_file($envFile);

    try {
        $conn = new PDO("mysql:host=".$env['host'].";dbname=".$env['database']."", $env['username'], $env['password']);
        return $conn;
    }catch(PDOException $e){
        exit("Erro: " . $e->getMessage());
    }
}