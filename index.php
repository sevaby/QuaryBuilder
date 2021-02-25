<?php
/**
 * @var QueryBuilder $db
 */
$db = include 'startBase.php';

$db
    ->select(['title'])
    ->from('posts')
    ->where('distance=:distance')
    ->andWhere('title=:title')
    ->andWhere('title1=:title2')
    ->orWhere('title=:title')
    ->setParameters([':title' => 'title'])
    ->orderBy(['distance' => 'DESC', 'id' => 'ASC'])
;

var_dump($db->getSQL());




