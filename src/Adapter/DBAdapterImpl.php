<?php

namespace App\Adapter;

use PDO;

/**
 * Implémentation de la connection à la BDD
 */
class DBAdapterImpl implements DBAdapter {

    public function createConnection(DataBase $dataBase): void {
        $pdo = new PDO($dataBase->getUrl(), $dataBase->getUsername(), $dataBase->getPassword());
    }
}