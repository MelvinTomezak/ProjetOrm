<?php

namespace App\Query;

use App\Model\VO\Uid;
use DateTime;
use ReflectionClass;

class QueryBuilderImpl implements QueryBuilder {

    public function save(object $object, string $table): string {
        $queries = $this->generate($object);

        $columns = implode(',', $queries[0]);
        $values = implode(',', $queries[1]);

        return "INSERT INTO $table($columns) VALUES($values);" ;
    }

    public function delete(object $object, string $table): string {
        return '';
    }

    public function update(object $object, string $table): string {
        $columns = $this->generate($object)[0];
        $values = $this->generate($object)[1];

        $value = "";
        foreach ($columns as $index => $column){
            $value = $value . $column . " = " . $values[$index] . ",";
        }

        return "UPDATE $table set $value";
    }

    public function findById(Uid $id, string $table): string {
        return "";
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

                $values[] = $value;
            }
        }

        $result[] = $columns;
        $result[] = $values;

        return $result;
    }
}