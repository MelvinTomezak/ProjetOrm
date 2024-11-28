<?php

namespace App\Repository;

use App\Adapter\DBAdapter;
use App\Model\News;
use App\Model\VO\Uid;
use App\Query\QueryBuilder;
use Src\Repository\RepositoryInterface;

class NewsRepository implements RepositoryInterface
{
    private QueryBuilder $queryBuilder;
    private DBAdapter $dbAdapter;

    public function __construct(QueryBuilder $queryBuilder, DBAdapter $dbAdapter)
    {
        $this->queryBuilder = $queryBuilder; 
        $this->dbAdapter = $dbAdapter; 
    }

    //Méthode pour enregistrer une entité News dans la base de données.
     
    public function save(object $entity): void
    {
        // Vérification que l'entité est bien de type News.
        if (!$entity instanceof News) {
            throw new \InvalidArgumentException("L'entité doit être une instance de News.");
        }

        // Utilisation du QueryBuilder pour créer la requête d'insertion.
        $query = $this->queryBuilder->save($entity, 'news');
        // Exécution de la requête via DBAdapter.
        $this->dbAdapter->execute($query);
    }

    //Méthode pour mettre à jour une entité News dans la base de données.
    public function update(object $entity): void
    {
        // Vérification que l'entité passée est bien de type News.
        if (!$entity instanceof News) {
            throw new \InvalidArgumentException("L'entité doit être une instance de News.");
        }

        // QueryBuilder pour créer la requête de mise à jour.
        $query = $this->queryBuilder->update($entity, 'news');
        // Exécution de la requête via DBAdapter.
        $this->dbAdapter->execute($query);
    }

    //Méthode pour supprimer une entité News de la base de données.
    public function delete(object $entity): void
    {
        // Vérification que l'entité passée est bien de type News.
        if (!$entity instanceof News) {
            throw new \InvalidArgumentException("L'entité doit être une instance de News.");
        }

        // Utilisation de l'ID de l'entité pour la suppression.
        $id = $entity->getId();
        $query = $this->queryBuilder->delete($entity, 'news');
        $this->dbAdapter->execute($query);
    }

    //Méthode pour trouver une entité News par son ID.
    public function findById(Uid $id): ?News
    {
        // Utilisation du QueryBuilder pour créer la requête de recherche par ID.
        $query = $this->queryBuilder->findById($id, 'news');
        $result = $this->dbAdapter->execute($query);

        // Si aucun résultat n'est trouvé, on retourne null.
        if (empty($result)) {
            return null;
        }

        // Retourne l'entité News mappée depuis le résultat de la base de données.
        return $this->mapRowToEntity($result[0]);
    }

    // Méthode pour trouver toutes les entités News.
     
    public function findAll(): array
    {
        // Requête SQL simple pour récupérer toutes les actualités.
        $query = "SELECT * FROM news";
        $results = $this->dbAdapter->execute($query);

        // Conversion de chaque résultat en une instance de News et retour du tableau.
        return array_map([$this, 'mapRowToEntity'], $results);
    }

    // Méthode privée pour mapper un tableau associatif à une instance de News.
  
    private function mapRowToEntity(array $row): News
    {
        $news = new News(); // Création d'une nouvelle instance de News.
        $news->setId(new Uid($row['id'])); // Initialisation de l'ID de l'entité avec un objet Uid.
        $news->setContent($row['content']); // Initialisation du contenu de l'entité.
        $news->setCreatedAt(new \DateTimeImmutable($row['created_at'])); // Initialisation de la date de création.

        return $news; // Retour de l'entité construite.
    }
}