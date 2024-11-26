<?php 

namespace src\Repository;

use Src\Adapter\AdapterInterface; 
use Src\Query\EntityBuilder;
use Src\Model\News;
use Src\Model\VO\Uid;


//Implémentation du repository pour 'News'

class NewsRepository implements RepositoryInterface
{ 
    private AdapterInterface $adapter;
    private EntityBuilder $builder;

    public function __construct (AdapterInterface $adapter, EntityBuilder $builder){
        $this -> adapter = $adapter;
        $this -> builder = $builder;
    }

    public function findById (Uid $id): ?News {

        $query = "Select * FROM news WHERE id = id";
        $result = $this->adapter->query($query, ['id' => $id->getValue()]);

        if (empty ($result)){
            return null;
        }
        return $this->builder->build(News:: class, $result[0]);
    }


    public function save (object $entity) : void {

        if (!$entity instanceof News){
            throw new \InvalidArgumentException('Invalid entity type, exepcted News');
        }

        $query = "INSERT INTO news (id, content, created_at) VALUES (:id, : content, :created_at)";
        $this-> adapter -> execute ($query, [
            'id' => $entity->getId()->getValue(),
            'content'=> $entity->getContent(),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    public function update (object $entity) : void {
        if (!$entity instanceof News){
            throw new \InvalidArgumentException('Invalid entity type, expected News.');
        }

        $query = "UPDATE news SET content = :content, created_at = :created_at WHERE id= :id";
        $this -> adapter -> execute ($query, [
            'id'=> $entity -> getId()->getValue(),
            'content'=> $entity ->getContent(),
            'created_at' => $entity->getCreatedAt() -> format('Y-m-d H:i:s'),
        ]); 
    }
    public function delete (object $entity) : void {

        if (!$entity instanceof News){
            throw new \InvalidArgumentException('Invalid entity type, expected News.');
        }

        $query = "DELETE FROM news WHERE id = :id";
        $this->adapter->execute ($query, [
            'id'=> $entity->getId()->getValue(),
        ]);
    }
}