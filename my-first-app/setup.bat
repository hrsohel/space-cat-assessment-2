@echo off
REM This batch file helps you find and use PHP

echo Searching for PHP installation...
echo.

REM Check XAMPP
if exist "C:\xampp\php\php.exe" (
    echo [FOUND] XAMPP PHP at C:\xampp\php\php.exe
    set "PHP_PATH=C:\xampp\php\php.exe"
    goto :found
)

REM Check Laragon (multiple versions)
for /d %%i in (C:\laragon\bin\php\php-*) do (
    if exist "%%i\php.exe" (
        echo [FOUND] Laragon PHP at %%i\php.exe
        set "PHP_PATH=%%i\php.exe"
        goto :found
    )
)

REM Check standard PHP
if exist "C:\php\php.exe" (
    echo [FOUND] PHP at C:\php\php.exe
    set "PHP_PATH=C:\php\php.exe"
    goto :found
)

REM Check Herd
if exist "%USERPROFILE%\.config\herd\bin\php.exe" (
    echo [FOUND] Herd PHP at %USERPROFILE%\.config\herd\bin\php.exe
    set "PHP_PATH=%USERPROFILE%\.config\herd\bin\php.exe"
    goto :found
)

echo [NOT FOUND] PHP not found in common locations!
echo.
echo Please install PHP using one of these:
echo - Laragon: https://laragon.org/download/
echo - XAMPP: https://www.apachefriends.org/
echo - Herd: https://herd.laravel.com/windows
echo.
pause
exit /b 1

:found
echo.
echo =====================================
echo Running Laravel Setup
echo =====================================
echo.

echo Step 1: Running migrations...
"%PHP_PATH%" artisan migrate --force
if %errorlevel% neq 0 (
    echo [ERROR] Migration failed!
    pause
    exit /b 1
)

echo.
echo Step 2: Fetching photos from API...
"%PHP_PATH%" artisan app:fetch-photos
if %errorlevel% neq 0 (
    echo [ERROR] Failed to fetch photos!
    pause
    exit /b 1
)

echo.
echo =====================================
echo Setup Complete!
echo =====================================
echo.
echo To start the server, run:
echo "%PHP_PATH%" artisan serve
echo.
echo Then visit: http://localhost:8000/photos
echo.
pause
