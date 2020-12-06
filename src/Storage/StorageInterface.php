<?php

namespace App\Storage;

use App\Entity\Entity;

interface StorageInterface{

    public function getById(int $id);
    public function fetchAll();
    public function flush(Entity $entity);
    public function update(Entity $entity, array $data);
    public function delete($id);

}