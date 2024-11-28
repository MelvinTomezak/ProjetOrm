<?php

namespace App\Adapter;

interface DBAdapter {

    public function execute(string $query, array $parameters = []): array | int;
}