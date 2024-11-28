<?php

namespace App\Adapter;

use InvalidArgumentException;
use PDO;
use PDOException;

/**
 * Implémentation de la connection à la BDD
 */
class DBAdapterImpl implements DBAdapter {

    private DataBase $dataBase;

    public function __construct(DataBase $dataBase){
     $this->dataBase = $dataBase;
    }

    private function createConnection(): PDO {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($this->dataBase->getUrl(), $this->dataBase->getUsername(), $this->dataBase->getPassword(), $options);
    }

    public function execute(string $query, array $parameters = []) : array | int{
        $pdo = $this->createConnection();
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($parameters);

            if (stripos($query, 'SELECT') === 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new InvalidArgumentException("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }
    }
}
