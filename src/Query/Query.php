<?php

namespace App\Query;

class Query {

    private string $content;

    public function __construct(string $content){
        $this->content = $content;
    }

    public function getContent(): string{
        return $this->content;
    }
}