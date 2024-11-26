<?php

namespace App\Query;

use ReflectionClass;
use ReflectionProperty;

class QueryBuilderImpl implements QueryBuilder {

    public function save(object $object, string $table): string {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $columns = [];
        $values = [];
        foreach ($properties as $property) {
            $columns[] = $property->getName();
            $values[] = ':' . $property->getValue($object);
        }

        $columnsString = implode(', ', $columns);
        $valuesString = implode(', ', $values);

        return "INSERT INTO $table ($columnsString) VALUES ($valuesString);" ;
    }

    public function delete(object $object): string {
        return '';
    }

    public function update(object $object): string {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $columns = [];
        $values = [];
        foreach ($properties as $property) {
            $columns[] = $property->getName();
            $values[] = ':' . $property->getValue($object);
        }

        return '';
    }

    public function findAll(string $table): string {
        return "select * from $table";
    }
}