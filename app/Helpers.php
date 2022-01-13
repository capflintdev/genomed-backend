<?php

namespace App;

class Helpers
{
    protected int $counter = 0;

    public function countRows(object $class, array $method): int
    {
        var_dump($class, $method);
        while ($class->method){
            $this->counter++;
        }
        return $this->counter;
    }
}