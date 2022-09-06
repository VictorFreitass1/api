<?php 
// Conexão com banco de dados da app mobile ionic
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Crendentials: true');
header('Access-Control-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-With');
header('Content-Type: application/json; charset=utf-8');

// Dados do servidor local
$banco = 'controledb';
$host = 'localhost'; // 127.0.0.1
$usuario = 'root';
$senha = '';

/*
// Dados do servidor remoto/hospedado
$banco = 'wellingtom_91';
$host = 'softkleen.com.br'; // 127.0.0.1
$usuario = 'apiti9111';
$senha = '';
*/

try{
    $pdo = new PDO("mysql:dbname=$banco;host=$host","$usuario", "$senha");
} catch (Exception $e){
    echo 'Erro ao conectar com o banco!';
}



?>