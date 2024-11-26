<?php 

namespace src\Repository;

use Src\Adapter\AdapterInterface; 
use src\NewsEntityManager;
use Src\Query\EntityBuilder;
use Src\Model\News;
use Src\Model\VO\Uid;


//Implémentation du repository pour 'News'

class NewsRepository implements RepositoryInterface
{ 
    private AdapterInterface $adapter;
    private NewsEntityManager $entityManager;

    public function __construct (AdapterInterface $adapter, EntityBuilder $builder, NewsEntityManager $entityManager){
        $this -> adapter = $adapter;
        $this ->entityManager = $entityManager;
    }

    public function findById (Uid $id): ?News {

        $query = EntityBuilder :: getById();
        $result = $this->adapter->query($query, ['id' => $id->getValue()]);

        if (empty ($result)){
            return null;
        }
        return $this->entityManager->build(News:: class, $result[0]);
    }


    public function save (object $entity) : void {

        if (!$entity instanceof News){
            throw new \InvalidArgumentException('Invalid entity type, exepcted News');
        }

        $query = NewsQuery :: save();

        $this->adapter->execute($query, [
            'id' => $entity->getId()->getValue(),
            'content' => $entity-> getContent(),
            'created_at' => $entity->getCreatedAt()-> format('Y-m-d H:i:s')
        ]);
    }

    public function update (object $entity) : void {
        if (!$entity instanceof News){
            throw new \InvalidArgumentException('Invalid entity type, expected News.');
        }

        $query = NewsQuery:: update();

$this->adapter->execute($query, [
    'id' => $entity->getId()-> getValue(),
    'content'=> $entity->getContent(),
    'created_at'=> $entity->getCreatedAt()->format('Y-m-d H:i:s')
]);
    }
    public function delete (object $entity) : void {

        if (!$entity instanceof News){
            throw new \InvalidArgumentException('Invalid entity type, expected News.');
        }

        $query = NewsQuery::delete();
       $this->adapter->execute($query,[
        'id' => $entity->getId()->getValue(),
       ]);
    }
}