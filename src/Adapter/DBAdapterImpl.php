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
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Gérer les erreurs avec des exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mode de récupération par défaut
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Empêcher l'émulation des requêtes préparées
            ];

            $pdo = new PDO($dataBase->getUrl(), $dataBase->getUsername(), $dataBase->getPassword(), $options);
        } catch (PDOException $exception){
            echo 'Erreur dans la connexion';
        }
    }
}
