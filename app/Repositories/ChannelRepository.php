<?php

namespace App\Repositories;

use App\Interfaces\ChannelRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function find(int $id): array
    {
        $results = DB::select("SELECT * FROM channels WHERE id = ?", [$id]);
        return $results[0] ?? [];
    }

    public function findByName(string $name): array
    {
        $results = DB::select("SELECT * FROM channels WHERE channel_name = ?", [$name]);
        return $results[0] ?? [];
    }

    public function findAll(): array
    {
        return DB::select("SELECT * FROM channels");
    }

    public function create(array $data): bool
    {
        foreach (['channel_name'] as $column) {
            if (empty($data[$column])) {
                throw new \InvalidArgumentException("Missing field '$column' from insert");
            }
        }

        return DB::insert('INSERT INTO channels (channel_name) VALUES (?)', $data);
    }

    public function delete(int $id): int
    {
        return DB::delete('DELETE FROM channels WHERE id = ?', [$id]);
    }
}
