<?php


namespace Src\Model\VO; 


//VO contient les objets valeur donc ici 'Uid'

class Uid 
{
    private string $value;

    public function __construct (string $value)
    {
        if (empty ($value)){
            throw new \InvalidArgumentException('ID cannot be empty');
        }
        $this -> value = $value;
    }

    public function getValue() : string 
    {
        return $this -> value;

    }

    public function setValue (string $value) : void
    {
        if (empty($value)){
            throw new \InvalidArgumentException("ID cannot be empty");
        }
        $this -> value = $value;
    }
}
