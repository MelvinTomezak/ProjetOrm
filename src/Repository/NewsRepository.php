<?php

namespace App\Repository;

use App\Adapter\DBAdapter;
use App\Model\News;
use App\Model\VO\Uid;
use App\Query\QueryBuilder;
use DateTimeImmutable;
use Exception;
use InvalidArgumentException;

final class NewsRepository implements RepositoryInterface
{
    private QueryBuilder $queryBuilder;
    private DBAdapter $dbAdapter;

    private static ?NewsRepository $instance = null;

    /**
     * Constructeur privé pour empêcher l'instanciation directe
     */
    private function __construct(QueryBuilder $queryBuilder, DBAdapter $dbAdapter) {
        $this->queryBuilder = $queryBuilder;
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Méthode statique pour récupérer l'instance unique
     */
    public static function getInstance(QueryBuilder $queryBuilder, DBAdapter $dbAdapter): NewsRepository
    {
        if (self::$instance === null) {
            self::$instance = new NewsRepository($queryBuilder, $dbAdapter);
        }

        return self::$instance;
    }

    /**
     * Méthode pour trouver une entité News par son ID
     * @throws Exception
     */
    public function findById(Uid $id): ?News
    {
        $query = $this->queryBuilder->findById($id, 'news');
        $result = $this->dbAdapter->execute($query);

        if (empty($result)) {
            return null;
        }

        return $this->mapRowToEntity($result[0]);
    }

    /**
     * Méthode pour trouver toutes les entités News
     */
    public function findAll(): array {
        $query = $this->queryBuilder->findAll('news');
        $results = $this->dbAdapter->execute($query);

        return array_map([$this, 'mapRowToEntity'], $results);
    }

    /** Méthode privée pour mapper un tableau associatif à une instance de News.
     * @throws Exception
     */
    private function mapRowToEntity(array $row): News {
        $news = new News($row['content']);
        $news->setId(new Uid($row['id']));
        $news->setCreatedAt(new DateTimeImmutable($row['created_at']));

        return $news;
    }
}
