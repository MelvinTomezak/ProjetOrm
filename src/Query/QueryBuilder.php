<?php

namespace App\Query;

use App\Model\VO\Uid;

/**
 * Génère les requetes SQL
 */
interface QueryBuilder {

    public function save(object $object, string $table): string;

    public function delete(object $object, string $table): string;

    public function update(object $object, string $table): string;

    public function findById(Uid $id, string $table): string;
}