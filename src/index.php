<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Adapter\DBAdapterImpl;
use App\Adapter\DataBase;
use App\Query\QueryBuilder;
use App\Query\Query;

//$host = '0.0.0.0'; // Serveur MySQL
//$port = '3306';      // Port de MySQL (par défaut 3306)
//$db   = 'ormdatabase'; // Nom de votre base de données
//$charset = 'utf8mb4'; // Jeu de caractères utilisé par la base de données
//
//$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
//
//$db = new DataBase($dsn, 'user', 'password');
//
//$dbAdapter = new DBAdapterImpl();
//$dbAdapter->createConnection($db);

$query = new Query('select $ from users', \App\Query\SqlMethod::SELECT);

$queryBuilder = new QueryBuilder();
$queryBuilder->execute($query);