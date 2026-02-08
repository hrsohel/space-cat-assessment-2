<?php

namespace App\Repositories;

use App\Models\Photo;
use App\Repositories\Interfaces\PhotoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PhotoRepository implements PhotoRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Photo::orderBy('id', 'asc')->paginate($perPage);
    }

    public function bulkInsert(array $photos): bool
    {
        try {
            $chunks = array_chunk($photos, 500);
            
            foreach ($chunks as $chunk) {
                Photo::insert($chunk);
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to bulk insert photos: ' . $e->getMessage());
            return false;
        }
    }

    public function count(): int
    {
        return Photo::count();
    }

    public function truncate(): bool
    {
        try {
            Photo::truncate();
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to truncate photos: ' . $e->getMessage());
            return false;
        }
    }
}
