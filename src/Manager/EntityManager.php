<?php

namespace App\Manager;

use App\Model\Entity;
use App\Model\VO\Uid;

interface EntityManager {

    public function save(Entity $entity): void;
    public function delete(Entity $entity): void;
    public function update(Entity $entity);
    public function findById(Uid $id) : ?Entity;
    public function findAll() : array | null;
}