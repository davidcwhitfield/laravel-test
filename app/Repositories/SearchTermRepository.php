<?php


namespace App\Repositories;

use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\File;

class SearchTermRepository
{
    private $termsFile;

    public function __construct()
    {
        $this->termsFile = base_path(config('files.search_terms.path'));
    }

    public function findAll(): array
    {
        if (!File::exists($this->termsFile) || !File::isReadable($this->termsFile)) {
            throw new \InvalidArgumentException("File '" . $this->termsFile . "' does not exist, or is not readable");
        }

        return array_map('trim', file($this->termsFile));
    }
}
