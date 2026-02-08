# Photo Gallery Assessment

A Laravel-based gallery application that synchronizes data from JSONPlaceholder API.

## 🚀 How to Run

This project is located in the `my-first-app` directory.

1. **Enter the project directory:**
   ```bash
   cd my-first-app
   ```

2. **Automated Setup (Windows):**
   Simply run the setup batch file:
   ```powershell
   ./setup.bat
   ```
   *This will run migrations and fetch the 5,000 photos for you.*

3. **Start the Server:**
   Run the serve batch file:
   ```powershell
   ./serve.bat
   ```
   Or run manually:
   ```bash
   php artisan serve
   ```

4. **View the Gallery:**
   Open: [http://localhost:8000/](http://localhost:8000/)

---

## Technical Overview

- **Architecture**: Implements Repository and Service patterns.
- **Data Synchronization**: Uses chunked insertion (500 per batch) for 5,000 records.
- **Zero Node.js**: Built with pure Blade and Vanilla CSS. No `npm install` required.
- **Resilience**: Features automatic API retry logic and a "self-healing" image URL transformer.





# Photo Gallery Assessment

A Laravel-based gallery application that synchronizes data from JSONPlaceholder API and provides a responsive, performant interface for viewing photos.

## Quick Start (Running the App)

1. **Start the Server:**
   You can use the provided batch file (on Windows):
   ```powershell
   ./serve.bat
   ```
   Or run the manual command:
   ```bash
   php artisan serve
   ```

2. **View the Gallery:**
   Open: [http://localhost:8000/](http://localhost:8000/)

---

## Technical Overview

- **Architecture**: Implements the Repository and Service patterns for clean separation of concerns.
- **Data Synchronization**: The command `php artisan app:fetch-photos` fetches 5,000 records using chunked insertion (500 per batch) to minimize memory usage and DB round-trips.
- **Resilience**: The Service layer includes automatic retry logic for the external API.
- **Frontend**: Built with Vanilla CSS and native Blade templates. No Node.js/NPM build step is required.
- **UI Optimizations**: Includes lazy-loading for images and a dynamic URL transformer to handle downtime from the original placeholder service.

---

## Installation (First Time Setup)

1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Environment:**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

3. **Database:**
   ```bash
   touch database/database.sqlite && php artisan migrate --force
   php artisan migrate
   php artisan app:fetch-photos
   ```

---

## Security & Performance

- **Sanitization**: Pagination parameters are strictly validated and cast in the Controller.
- **Indexing**: Database index on `album_id` for optimized filtering.
- **Error Handling**: Detailed logs are written to `storage/logs/laravel.log` while generic responses are shown to the user.




