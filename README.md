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

For more technical details, see the documentation inside the `my-first-app` folder.
