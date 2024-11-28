<?php

namespace src\Repository;

use App\Adapter\DBAdapter;
use App\Query\QueryBuilder;
use src\Model\News;
use src\Model\VO\Uid;

class NewsRepository implements RepositoryInterface
{
    private DBAdapter $adapter;
    private QueryBuilder $queryBuilder;

    public function __construct(DBAdapter $adapter, QueryBuilder $queryBuilder)
    {
        $this->adapter = $adapter;
        $this->queryBuilder = $queryBuilder;
    }

    public function findById(Uid $id): ?News
    {
        $query = $this->queryBuilder->findAll('news') . " WHERE id = :id";
        $result = $this->adapter->query($query, ['id' => $id->getValue()]);

        if (empty($result)) {
            return null;
        }

        return new News(
            new Uid($result[0]['id']),
            $result[0]['content'],
            new \DateTime($result[0]['created_at'])
        );
    }

    public function save(object $entity): void
    {
        if (!$entity instanceof News) {
            throw new \InvalidArgumentException('Invalid entity type, expected News.');
        }

        $query = $this->queryBuilder->save($entity, 'news');
        $this->adapter->execute($query, $this->extractParameters($entity));
    }

    public function update(object $entity): void
    {
        if (!$entity instanceof News) {
            throw new \InvalidArgumentException('Invalid entity type, expected News.');
        }

        $query = $this->queryBuilder->update($entity);
        $this->adapter->execute($query, $this->extractParameters($entity));
    }

    public function delete(object $entity): void
    {
        if (!$entity instanceof News) {
            throw new \InvalidArgumentException('Invalid entity type, expected News.');
        }

        $query = $this->queryBuilder->delete($entity);
        $this->adapter->execute($query, ['id' => $entity->getId()->getValue()]);
    }

    private function extractParameters(News $news): array
    {
        return [
            'id' => $news->getId()->getValue(),
            'content' => $news->getContent(),
            'created_at' => $news->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
