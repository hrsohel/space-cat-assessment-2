# Setup Guide - PHP Path Issue

## Problem
PHP is not accessible from the command line. This prevents running Laravel commands like `php artisan migrate`.

## Solutions

### Option 1: Find Your PHP Installation

PHP might be installed but not in your system PATH. Common locations:
- XAMPP: `C:\xampp\php\php.exe`
- Laragon: `C:\laragon\bin\php\php-8.x\php.exe`
- Standalone: `C:\php\php.exe`
- Herd: `C:\Users\[YourUser]\.config\herd\bin\php.exe`

**Check Windows Programs:**
1. Open "Add/Remove Programs"
2. Look for PHP, XAMPP, Laragon, Herd, or similar

### Option 2: Use Full Path to PHP

If you find PHP installed, you can run commands like:
```bash
C:\xampp\php\php.exe artisan migrate
C:\xampp\php\php.exe artisan app:fetch-photos
C:\xampp\php\php.exe artisan serve
```

### Option 3: Add PHP to PATH (Recommended)

1. Find your PHP installation directory
2. Press `Win + X` → "System"
3. Click "Advanced system settings"
4. Click "Environment Variables"
5. Under "System variables", find "Path"
6. Click "Edit" → "New"
7. Add your PHP directory (e.g., `C:\xampp\php`)
8. Click "OK" on all windows
9. **Restart PowerShell** or Command Prompt

### Option 4: Install PHP (If Not Installed)

#### Using Laragon (Easiest):
1. Download from: https://laragon.org/download/
2. Install and start Laragon
3. PHP will be automatically configured

#### Using Herd (For Laravel):
1. Download from: https://herd.laravel.com/windows
2. Install - it includes PHP and everything needed for Laravel

## Quick Fix for This Project

Since you already have Laravel files, you likely have PHP somewhere. Try these:

### For XAMPP users:
```bash
cd c:\Users\hrsoh\Documents\backend\spacecat-assessent-2\my-first-app
C:\xampp\php\php.exe artisan migrate
C:\xampp\php\php.exe artisan app:fetch-photos
C:\xampp\php\php.exe artisan serve
```

### For Laragon users:
```bash
cd c:\Users\hrsoh\Documents\backend\spacecat-assessent-2\my-first-app
C:\laragon\bin\php\php-8.2-nts\php.exe artisan migrate
C:\laragon\bin\php\php-8.2-nts\php.exe artisan app:fetch-photos
C:\laragon\bin\php\php-8.2-nts\php.exe artisan serve
```

### For Herd users:
Open Herd's terminal directly (it has PHP in PATH automatically)

## After Fixing PHP Access

Run these commands in order:

1. **Create database file** (if missing):
   ```bash
   New-Item -Path database\database.sqlite -ItemType File -Force
   ```

2. **Run migrations**:
   ```bash
   php artisan migrate
   ```

3. **Fetch photos from API**:
   ```bash
   php artisan app:fetch-photos
   ```
   This will download 5,000 photos and store them in the database.

4. **Start the server**:
   ```bash
   php artisan serve
   ```

5. **View the photos**:
   Open browser: http://localhost:8000/photos

## Why Images Aren't Showing

The images won't show because:
1. ❌ Database hasn't been created/migrated
2. ❌ Photos haven't been fetched from the API
3. ❌ No data exists to display yet

Once you run the commands above, the images will appear! 🎉
