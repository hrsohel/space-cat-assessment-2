@echo off
REM This batch file helps you start the Laravel server

echo Searching for PHP installation...

REM Check XAMPP
if exist "C:\xampp\php\php.exe" (
    echo [FOUND] Using XAMPP PHP
    "C:\xampp\php\php.exe" artisan serve
    exit /b
)

REM Check Laragon
for /d %%i in (C:\laragon\bin\php\php-*) do (
    if exist "%%i\php.exe" (
        echo [FOUND] Using Laragon PHP
        "%%i\php.exe" artisan serve
        exit /b
    )
)

REM Check standard PHP
if exist "C:\php\php.exe" (
    echo [FOUND] Using standalone PHP
    "C:\php\php.exe" artisan serve
    exit /b
)

REM Check Herd
if exist "%USERPROFILE%\.config\herd\bin\php.exe" (
    echo [FOUND] Using Herd PHP
    "%USERPROFILE%\.config\herd\bin\php.exe" artisan serve
    exit /b
)

echo [ERROR] PHP not found!
echo Please run setup.bat first or install PHP.
pause
