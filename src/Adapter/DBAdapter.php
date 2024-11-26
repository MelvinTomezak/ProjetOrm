<?php

namespace App\Adapter;

interface DBAdapter {

    public function createConnection(DataBase $dataBase): void;
}