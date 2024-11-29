<?php

namespace App\Adapter;

use Exception;
use InvalidArgumentException;
use PDO;
use PDOException;

/**
 * Implémentation de la connection à la BDD
 */
class DBAdapterImpl implements DBAdapter {

    private PDO $connection;

    public function __construct(string $dsn, string $username, string $password){
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

//        $this->connection = new PDO($dsn, $username, $password, $options);
    }


    public function execute(string $query, array $parameters = []) : array | int{
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($parameters);

            if (stripos($query, 'SELECT') === 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new InvalidArgumentException("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }
    }

    public function executeWithTransaction(callable $operation): mixed{
        try {
            $this->connection->beginTransaction();

            // Exécute l'opération utilisateur passée sous forme de callable
            $result = $operation($this);

            $this->connection->commit();

            return $result;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new InvalidArgumentException("Erreur lors de l'exécution avec transaction : " . $e->getMessage());
        }
    }

    public function beginTransaction(): void{
        $this->connection->beginTransaction();
    }

    public function commit(): void{
        $this->connection->commit();
    }

    public function rollback(): void{
        $this->connection->rollBack();
    }
}
