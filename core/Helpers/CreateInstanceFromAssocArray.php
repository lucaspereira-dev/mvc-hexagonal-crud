<?php

namespace Core\Helpers;

use ReflectionClass;

class CreateInstanceFromAssocArray {
    public static function create ($className, $data) {
        $reflectionClass = new ReflectionClass($className);
        $constructor = $reflectionClass->getConstructor();
        $constructorParams = $constructor->getParameters();
        
        $params = [];
    
        foreach ($constructorParams as $param) {
            $paramName = $param->getName();
            $params[] = array_key_exists($paramName, $data) ? $data[$paramName] : null;
        }
        
        return $reflectionClass->newInstanceArgs($params);
    }
}
