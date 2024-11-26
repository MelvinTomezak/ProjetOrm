<?php

namespace App\Query;

use DateTime;
use ReflectionClass;
use ReflectionProperty;

class QueryBuilderImpl implements QueryBuilder {

    private array $columns;
    private array $values;

    public function save(object $object, string $table): string {
        $queries = $this->generate($object);

        return "INSERT INTO $table($queries[0]) VALUES($queries[1]);" ;
    }

    public function delete(object $object, string $table): string {
        return '';
    }

    public function update(object $object, string $table): string {

        return "UPDATE $table set ";
    }

    public function findAll(string $table): string {
        return "select * from $table";
    }

    private function generate(object $object) : array {
        $result = [];

        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $columns = [];
        $values = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);

            if ($property->isInitialized($object) && $property->getType()->getName() != "Uid") {
                $columns[] = $property->getName();

                $value = null;
                $type = $property->getType()->getName();
                switch ($type){
                    case 'int':
                    case 'float':
                        $value = $property->getValue($object);
                        break;
                    case 'DateTime':
                        $value = $property->getValue($object) instanceof DateTime ? $property->getValue($object)->format('Y-m-d H:i:s') : null;
                        break;
                    case 'string':
                    default:
                        $value = "'". $property->getValue($object) . "'";
                }


            }
        }

        $columnsString = implode(', ', $columns);
        $valuesString = implode(', ', $values);

        $result[] = $columnsString;
        $result[] = $valuesString;

        return $result;
    }
}