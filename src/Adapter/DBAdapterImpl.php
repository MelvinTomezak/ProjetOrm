<?php

namespace App\Adapter;

use PDO;
use PDOException;

/**
 * Implémentation de la connection à la BDD
 */
class DBAdapterImpl implements DBAdapter {

    public function createConnection(DataBase $dataBase): void {
        try {
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($dataBase->getUrl(), $dataBase->getUsername(), $dataBase->getPassword(), $options);
        } catch (PDOException $exception){
            echo 'Erreur dans la connexion';
        }
    }
}
