<?php

namespace App\Adapter;


/**
 * Base de données
 */
class DataBase {
    private string $url;
    private string $username;
    private string $password;

    public function __construct(string $url, string $username, $password){
        $this->password = $password;
        $this->url = $url;
        $this->username = $username;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }
}