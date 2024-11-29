<?php 

namespace App\Repository;

use App\Model\VO\Uid;

/**
 * Repository gère les interactions avec la BDD
 */
interface RepositoryInterface {

    /** Pour récupérer une news par son ID
     * @param Uid $id id
     * @return object|null l'objet trouvé
     */
    public function findById (Uid $id): ?object ;
    public function findAll(): array;
}
