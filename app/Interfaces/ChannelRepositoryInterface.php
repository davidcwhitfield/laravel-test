<?php

namespace App\Interfaces;

interface ChannelRepositoryInterface
{
    public function find(int $id);

    public function findAll();

    public function findByName(string $name);

    public function create(array $data);

    public function delete(int $id);
}
