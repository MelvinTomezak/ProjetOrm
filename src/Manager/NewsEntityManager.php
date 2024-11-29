<?php

namespace App\Manager;

use App\Adapter\DBAdapter;
use App\Model\Entity;
use App\Model\News;
use App\Query\QueryBuilder;
use App\Repository\NewsRepository;
use App\Model\VO\Uid;
use Exception;
use InvalidArgumentException;

class NewsEntityManager implements EntityManager {
    private NewsRepository $newsRepository;
    private QueryBuilder $queryBuilder;
    private DBAdapter $dbAdapter;

    public function __construct(QueryBuilder $queryBuilder, DBAdapter $dbAdapter) {
        $this->newsRepository = NewsRepository::getInstance($queryBuilder, $dbAdapter);
        $this->queryBuilder = $queryBuilder;
        $this->dbAdapter = $dbAdapter;
    }

    public function save(Entity $entity): void {
        $uid = new Uid(uniqid('news_', true));
        $entity->setId($uid);

        $query = $this->queryBuilder->save($entity, 'news');
        $this->dbAdapter->execute($query);
    }


    public function delete(Entity $entity): void {
        $query = $this->queryBuilder->delete($entity, 'news');
        $this->dbAdapter->execute($query);    }

    public function update(Entity $entity): void {
        if ($entity->getId() === null) {
            throw new InvalidArgumentException("L'objet News doit avoir un ID pour être mis à jour.");
        }

        $query = $this->queryBuilder->update($entity, 'news');
        $this->dbAdapter->execute($query);
    }

    /**
     * @throws Exception
     */
    public function findById(Uid $id): ?Entity {
        return $this->newsRepository->findById($id);
    }

    public function findAll(): array|null {
        return $this->newsRepository->findAll();
    }
}
