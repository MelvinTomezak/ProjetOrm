<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Query\QueryBuilderImpl;
use App\Model\News;
use App\Model\VO\Uid;

$uuid = new Uid('value');

$news = new News();
$news->setContent('contenu');
//$news->setId($uuid);

$queryImpl = new QueryBuilderImpl();
echo $queryImpl->update($news, 'news');