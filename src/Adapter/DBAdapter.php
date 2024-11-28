<?php

namespace App\Adapter;

interface DBAdapter {

    public function execute(string $query, array $parameters = []): array | int;

    public function executeWithTransaction(callable $operation): mixed;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}