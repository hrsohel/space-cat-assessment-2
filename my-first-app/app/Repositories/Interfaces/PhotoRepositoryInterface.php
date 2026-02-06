<?php

namespace App\Repositories\Interfaces;

interface PhotoRepositoryInterface
{
    /**
     * Get all photos with pagination
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15);

    /**
     * Bulk insert photos
     *
     * @param array $photos
     * @return bool
     */
    public function bulkInsert(array $photos): bool;

    /**
     * Get total count of photos
     *
     * @return int
     */
    public function count(): int;

    /**
     * Clear all photos from database
     *
     * @return bool
     */
    public function truncate(): bool;
}
