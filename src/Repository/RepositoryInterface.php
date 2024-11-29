<?php 

namespace App\Repository;

use App\Model\VO\Uid;

//repository gère les interactions avec la bd pour News. 
interface RepositoryInterface
{
    public function findById (Uid $id): ?object ; //pour récupérer une news par son ID
    public function save (object $entity) : void; //pour insérer une nouvelle news
    public function update (object $entity): void; // pour mettre à jour une news existante
    public function delete (object $entity): void; // pour supprimer une news
}
