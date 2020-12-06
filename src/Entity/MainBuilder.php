<?php

namespace App\Entity;

abstract class MainBuilder{
    protected $data;
    protected $error;

    public function __construct(array $data = null){
        if($data != null){
            $this->data = $data;
        }
    }

    public function getData(){
        return $this->data;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function getError(){
        return $this->error;
    }

    public function setError($error){
        $this->error = $error;
    }

    public function addError(string $error){
        $this->error .= $error;
    }
}