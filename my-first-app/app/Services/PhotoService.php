<?php

namespace App\Services;

use App\Repositories\Interfaces\PhotoRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhotoService
{
    private const API_URL = 'https://jsonplaceholder.typicode.com/photos';
    private const REQUEST_TIMEOUT = 30; // seconds

    /**
     * @var PhotoRepositoryInterface
     */
    protected $photoRepository;

    /**
     * PhotoService constructor.
     * 
     * @param PhotoRepositoryInterface $photoRepository
     */
    public function __construct(PhotoRepositoryInterface $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * Fetch photos from external API and store in database
     *
     * @return array
     */
    public function fetchAndStorePhotos(): array
    {
        try {
            Log::info('Starting to fetch photos from API');

            // Fetch data from API with timeout handling
            $response = Http::timeout(self::REQUEST_TIMEOUT)
                ->retry(3, 100) // Retry 3 times with 100ms delay
                ->get(self::API_URL);

            if (!$response->successful()) {
                Log::error('API request failed with status: ' . $response->status());
                return [
                    'success' => false,
                    'message' => 'Failed to fetch data from API',
                    'status' => $response->status(),
                ];
            }

            $photos = $response->json();

            if (empty($photos)) {
                Log::warning('No photos returned from API');
                return [
                    'success' => false,
                    'message' => 'No photos found in API response',
                ];
            }

            Log::info('Fetched ' . count($photos) . ' photos from API');

            // Prepare data for bulk insert
            $preparedPhotos = $this->preparePhotosForStorage($photos);

            // Clear existing data (optional - depends on requirements)
            // $this->photoRepository->truncate();

            // Store in database using chunked insertion
            $result = $this->photoRepository->bulkInsert($preparedPhotos);

            if ($result) {
                $totalCount = $this->photoRepository->count();
                Log::info('Successfully stored photos. Total in DB: ' . $totalCount);

                return [
                    'success' => true,
                    'message' => 'Photos fetched and stored successfully',
                    'count' => count($preparedPhotos),
                    'total' => $totalCount,
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to store photos in database',
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error when fetching photos: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching and storing photos: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Prepare photos data for storage
     *
     * @param array $photos
     * @return array
     */
    private function preparePhotosForStorage(array $photos): array
    {
        $now = now();
        
        return array_map(function ($photo) use ($now) {
            return [
                'id' => $photo['id'] ?? null,
                'album_id' => $photo['albumId'] ?? 0,
                'title' => $photo['title'] ?? '',
                'url' => $photo['url'] ?? '',
                'thumbnail_url' => $photo['thumbnailUrl'] ?? '',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $photos);
    }

    /**
     * Get all photos with pagination
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllPhotos(int $perPage = 15)
    {
        return $this->photoRepository->getAllPaginated($perPage);
    }
}
