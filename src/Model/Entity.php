<?php

namespace App\Model;

use App\Model\VO\Uid;

abstract class Entity {
    private Uid $id;

    public function getId(): Uid {
        return $this->id;
    }

    public function setId(Uid $id): void {
        $this->id = $id;
    }
}