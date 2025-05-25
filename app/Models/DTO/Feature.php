<?php

namespace App\Models\DTO;

class Feature
{
    private $name;    
    private $route;
    private $img_name;

    function __construct($name, $route, $img_name){
        $this->name=$name;
        $this->route=$route;
        $this->img_name=$img_name;
    }

    public function getName(){
        return $this->name;
    }

    public function getRoute(){
        return $this->route;
    }

    public function getImgName(){
        return $this->img_name;
    }
}