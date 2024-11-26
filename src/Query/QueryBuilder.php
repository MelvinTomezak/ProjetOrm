<?php

namespace App\Query;

/**
 * Génère les requetes SQL
 */
interface QueryBuilder {

    public function save(object $object, string $table): string;

    public function delete(object $object): string;

    public function update(object $object): string;

    public function findAll(string $table): string;
}