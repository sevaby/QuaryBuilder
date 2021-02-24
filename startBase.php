<?php
$config = include 'config.php';
include 'QueryBuilder.php';
include 'Connection.php';

$db = new QueryBuilder(Connection::make($config['database']));
return $db;
