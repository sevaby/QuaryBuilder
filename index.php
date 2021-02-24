<?php
$db = include 'startBase.php';


//$db->add('posts', ['title' => 'Moscow', 'distance' => 960]);
//var_dump($db->selectOne('posts', '3'));
//$db->update('posts',['title' => 'Pervomaisk', 'distance' => 15], 12);
$db->delete('posts', 12);