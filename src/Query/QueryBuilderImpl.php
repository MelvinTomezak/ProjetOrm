<?php

namespace App\Query;

use App\Model\VO\Uid;
use DateTime;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

class QueryBuilderImpl implements QueryBuilder {

    public function save(object $object, string $table): string {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $columns = [];
        $placeholders = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);

            if ($property->isInitialized($object)) {
                $value = $property->getValue($object);

                if (is_object($value)) {
                    if ($value instanceof \DateTimeImmutable) {
                        $value = $value->format('Y-m-d H:i:s'); // Format DateTime
                    } elseif ($value instanceof \App\Model\VO\Uid) {
                        $value = $value->getValue(); // Extraire la valeur de Uid
                    } elseif (property_exists($value, 'id')) {
                        $value = $value->id;
                    } else {
                        throw new InvalidArgumentException("La propriété {$property->getName()} contient un objet non gérable.");
                    }
                }
                if(is_string($value)){
                    $value = "'$value'";
                }

                $columns[] = $property->getName();
                $placeholders[] = $value;
            }
        }

        $columnsString = implode(', ', $columns);
        $placeholdersString = implode(', ', $placeholders);


        return "INSERT INTO $table($columnsString) VALUES($placeholdersString);" ;
    }


    /**
     * @throws ReflectionException
     */
    public function delete(object $object, string $table): string
    {
        $reflection = new ReflectionClass($object);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);

        if (!$idProperty->isInitialized($object)) {
            throw new InvalidArgumentException("L'objet à supprimer n'a pas d'ID initialisé.");
        }

        $id = $idProperty->getValue($object);

        if ($id instanceof Uid) {
            $id = $id->getValue();
        }

        return "DELETE FROM $table WHERE id = $id;";
    }



    public function update(object $object, string $table): string
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $updates = [];
        $idValue = null;

        foreach ($properties as $property) {
            $property->setAccessible(true);

            if ($property->isInitialized($object)) {
                $value = $property->getValue($object);

                if ($property->getName() === 'id') {
                    if ($value instanceof Uid) {
                        $idValue = $value->getValue();
                    } else {
                        $idValue = $value;
                    }
                    continue;
                }

                if (is_object($value)) {
                    if ($value instanceof DateTime) {
                        $value = $value->format('Y-m-d H:i:s');
                    } elseif ($value instanceof Uid) {
                        $value = $value->getValue();
                    } elseif (property_exists($value, 'id')) {
                        $value = $value->id;
                    } else {
                        throw new InvalidArgumentException("La propriété {$property->getName()} contient un objet non gérable.");
                    }
                }

                $updates[] = $property->getName() . ' = ' . $value;
            }
        }

        if ($idValue === null) {
            throw new InvalidArgumentException("L'objet à mettre à jour n'a pas d'ID.");
        }

        $updatesString = implode(', ', $updates);

        return "UPDATE $table SET $updatesString WHERE id = $idValue;";
    }


    public function findById(Uid $id, string $table): string {
        $value = $id->getValue();

        return "SELECT * FROM $table WHERE id = $value";
    }

    public function findAll(string $table): string {
        return "SELECT * FROM $table";
    }
}