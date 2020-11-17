<?php

namespace App\Storage;

interface StorageInterface{

    public function getById(int $id);
    public function fetchAll();
    public function flush($entity);
    public function update($entity, $data);
    public function delete($id);

}