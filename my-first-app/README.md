# Laravel Photo Gallery - Assessment Task

A robust Laravel application that fetches, stores, and displays photos from the JSONPlaceholder API. This project demonstrates efficient handling of large datasets using Repository and Service patterns.

## Features

- **Repository Pattern**: Clean separation of data access logic
- **Service Layer**: Business logic isolated from controllers
- **Efficient Bulk Insertion**: Chunked database inserts to handle large datasets
- **Error Handling**: Comprehensive error handling with logging
- **Modern UI**: Responsive, gradient-based photo gallery with pagination
- **Artisan Command**: CLI command for data fetching
- **API Retry Logic**: Automatic retry mechanism for failed API calls

## Technology Stack

- **Framework**: Laravel 11+
- **Database**: SQLite (easily switchable to MySQL/PostgreSQL)
- **External API**: [JSONPlaceholder](https://jsonplaceholder.typicode.com/)
- **Architecture**: Repository-Service-Controller pattern

## Installation & Setup

### Prerequisites

- PHP 8.2+
- Composer
- SQLite extension enabled

### Step-by-Step Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd my-first-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   
   The app uses SQLite by default (already configured in `.env`). Create the database file:
   ```bash
   touch database/database.sqlite
   ```

   Or on Windows:
   ```bash
   type nul > database/database.sqlite
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Fetch photos from API**
   ```bash
   php artisan app:fetch-photos
   ```
   This will fetch 5,000 photos from JSONPlaceholder and store them in the database.

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Visit the application**
   
   Open your browser and navigate to: [http://localhost:8000/photos](http://localhost:8000/photos)

## Project Structure

```
app/
├── Console/Commands/
│   └── FetchPhotos.php          # Artisan command for data fetching
├── Http/Controllers/
│   └── PhotoController.php      # Handles photo display
├── Models/
│   └── Photo.php                # Eloquent model
├── Repositories/
│   ├── Interfaces/
│   │   └── PhotoRepositoryInterface.php
│   └── PhotoRepository.php      # Database operations
└── Services/
    └── PhotoService.php         # API and business logic

resources/views/photos/
└── index.blade.php              # Photo gallery UI

database/migrations/
└── 2026_02_06_164850_create_photos_table.php
```

## How It Works

### 1. Data Fetching

The `PhotoService` class handles external API communication:
- Uses Laravel's HTTP client with timeout (30s)
- Implements retry logic (3 attempts with 100ms delay)
- Handles connection errors gracefully
- Logs all operations for debugging

### 2. Large Dataset Optimization

**Chunking Strategy:**
- API data is prepared in memory first
- Bulk insertion happens in chunks of 500 records
- Prevents memory exhaustion on large datasets
- Reduces database round-trips

**Database Optimizations:**
- Index on `album_id` for faster queries
- Uses `insert()` for batch operations
- Pagination on display (20 items per page by default)

### 3. Error Handling

- **API Failures**: Graceful handling with retry mechanism
- **Database Errors**: Try-catch blocks with logging
- **Validation**: Input sanitization on controller level
- **Logging**: All errors logged to `storage/logs/laravel.log`

### 4. Presentation

- **Responsive Grid**: Auto-adjusts based on screen size
- **Lazy Loading**: Images load as user scrolls
- **Pagination**: Server-side pagination for performance
- **Visual Feedback**: Hover effects and smooth transitions

## Usage

### Fetch Photos (CLI)

```bash
php artisan app:fetch-photos
```

This command will:
- Connect to JSONPlaceholder API
- Fetch all 5,000 photos
- Store them in chunks
- Display progress and results

### View Photos (Web)

Navigate to `/photos` to see the gallery. You can customize items per page:

```
http://localhost:8000/photos?per_page=50
```

Valid range: 1-100 items per page

## Architecture Decisions

### Why Repository Pattern?

- **Testability**: Easy to mock for unit tests
- **Flexibility**: Can swap database implementations
- **Separation of Concerns**: Database logic isolated from business logic

### Why Service Layer?

- **Business Logic Centralization**: All API and data processing logic in one place
- **Reusability**: Service methods can be used by controllers, commands, jobs, etc.
- **Easier Testing**: Mock dependencies easily

### Why Chunked Inserts?

- **Memory Efficiency**: Avoids loading all 5,000 records at once
- **Transaction Safety**: Smaller batches reduce lock times
- **Scalability**: Works with datasets of any size

## Challenges & Solutions

### Challenge 1: Memory Limitations with Large Datasets

**Problem**: Inserting 5,000 records at once could exhaust PHP memory.

**Solution**: Implemented chunked insertion (500 records per batch) in `PhotoRepository::bulkInsert()`.

### Challenge 2: API Timeout

**Problem**: External API might be slow or unreliable.

**Solution**: Added timeout (30s) and retry logic (3 attempts) in `PhotoService`.

### Challenge 3: Pagination Performance

**Problem**: Loading all photos on a single page would be slow.

**Solution**: Server-side pagination with Eloquent's `paginate()` method.

### Challenge 4: Database Schema Design

**Problem**: Needed to store photos efficiently while maintaining query performance.

**Solution**: Added index on `album_id` (frequently queried field) and used appropriate data types.

## Testing

The code is structured for easy testing:

```bash
php artisan test
```

## Future Enhancements

- Add photo search functionality
- Implement caching layer (Redis)
- Add queue support for async fetching
- Create API endpoints for JSON responses
- Add filters (by album, date, etc.)

## License

This project is created for assessment purposes.

## Author

Created as part of a Laravel assessment task demonstrating proficiency in:
- Laravel best practices
- Repository pattern implementation
- Service-oriented architecture
- Large dataset handling
- Clean code principles
