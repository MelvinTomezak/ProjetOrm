<?php

namespace App\Model;

use DateTimeImmutable;

/**
 * News
 */
class News extends Entity {
    private string $content;
    private DateTimeImmutable $createdAt;

    public function __construct(string $content){
        $this->createdAt = new DateTimeImmutable();
        $this->content = $content;
    }

    public function getContent() : string {
        return $this->content;
    }

    public function setContent(string $content) : self {
        $this-> content = $content; 
        return $this;
    }

    public function getCreatedAt (): DateTimeImmutable {
        return $this -> createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $date): self {
        $this->createdAt = $date;
        return $this;
    }
}