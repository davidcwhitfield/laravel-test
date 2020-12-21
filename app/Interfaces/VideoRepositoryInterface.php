<?php

namespace App\Interfaces;

interface VideoRepositoryInterface
{
    public function find(int $id);

    public function findAll();

    public function create(array $data);

    public function delete(int $id);
}
