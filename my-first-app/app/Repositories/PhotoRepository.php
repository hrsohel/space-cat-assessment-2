<?php

namespace App\Repositories;

use App\Models\Photo;
use App\Repositories\Interfaces\PhotoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PhotoRepository implements PhotoRepositoryInterface
{
    /**
     * Get all photos with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Photo::orderBy('id', 'asc')->paginate($perPage);
    }

    /**
     * Bulk insert photos using chunks to avoid memory issues
     *
     * @param array $photos
     * @return bool
     */
    public function bulkInsert(array $photos): bool
    {
        try {
            // Use chunk insertion for better performance with large datasets
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

    /**
     * Get total count of photos
     *
     * @return int
     */
    public function count(): int
    {
        return Photo::count();
    }

    /**
     * Clear all photos from database
     *
     * @return bool
     */
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
