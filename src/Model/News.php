<?php

namespace App\Model;

use App\Model\VO\Uid;

//entité 'News'

class News 
{
    private Uid $id; 
    private string $content;
    private \DateTimeImmutable $createdAt; 

    public function getId() : Uid
    {
        return $this->id;
    }

    public function setId(Uid $id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function getContent() : string 
    {
        return $this->content;
    }

    public function setContent(string $content) : self 
    {
        $this-> content = $content; 
        return $this;
    }


    public function getCreatedAt (): \DateTimeImmutable
    {
        return $this -> createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $date): self
    {
        $this->createdAt = $date;
        return $this;
    }
}