<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Adapter\DBAdapterImpl;
use App\Manager\NewsEntityManager;
use App\Query\QueryBuilderImpl;
use App\Model\News;
use App\Model\VO\Uid;

$uuid = new Uid('value');

$news = new News('contenu');
$news->setId($uuid);

$query = new QueryBuilderImpl();
$db = new DBAdapterImpl('mysql:localhost', 'ee', 'eee');

$entity = new NewsEntityManager($query, $db);
$entity->save($news);