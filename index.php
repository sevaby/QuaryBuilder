<?php
/**
 * @var QueryBuilder $db
 */
$db = include 'startBase.php';


//$db->add('posts', ['title' => 'Grodno', 'distance' => 107]);
//var_dump($db->selectOne('posts', '3'));
//$db->update('posts',['title' => 'Berlin', 'distance' => 1200], 12);
//$db->delete('posts', 12);

$db
    ->select(['title'])
    ->from('posts')
    ->where('distance=:distance')
    ->andWhere('title=:title')
    ->andWhere('title1=:title2')
    ->orWhere('title=:title')
    ->setParameters([':title' => 'title'])
    ->orderBy(['distance' => 'DESC', 'id' => 'ASC'])
//    ->addOrderBy()

;

//var_dump($db->getSQL());
//var_dump($db->orderBy);
var_dump($db->getSQL());




//$db = new DatabaseGateway();
//$db->insert('tableName', [
//    'id' => 1221,
//    'name' => 'sdsdsdsd'
//]);

//$qb = new QueryBuilder();

//$qb = $db->createQueryBuilder();
//
//
//$qb->select('*')
//    ->from('hui')
//    ->where('id = :id')
//    ->andWhere('enabled = :enabled1')
//    ->setParameters([
//        'id' => 1212121,
//        'enabled1' => true
//    ]);
//
//if (true) {
//    $qb->andWhere('hui = :qqq')
//        ->setParameters([
//            'qqq' => true
//        ]);
//}
//
//$qb->execute();



