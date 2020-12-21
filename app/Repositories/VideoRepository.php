<?php

namespace App\Repositories;

use App\Interfaces\VideoRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VideoRepository implements VideoRepositoryInterface
{
    public function find(int $id): array
    {
        $results = DB::select("SELECT * FROM videos WHERE id = ?", [$id]);
        return $results[0] ?? [];
    }

    public function findAll(): array
    {
        return DB::select("SELECT * FROM videos");
    }

    public function create(array $data): bool
    {
        foreach (['id', 'title', 'date'] as $column) {
            if (empty($data[$column])) {
                throw new \InvalidArgumentException("Missing field '$column' from insert");
            }
        }

        return DB::insert('INSERT INTO videos (id, title, date) VALUES (?, ?, ?)', $data);
    }

    public function delete(int $id): int
    {
        return DB::delete('DELETE FROM videos WHERE id = ?', [$id]);
    }
}
