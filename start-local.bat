@echo off
cd /d "%~dp0"
if exist "%~dp0.tools\php83\php.exe" (
    set "PATH=%~dp0.tools\php83;%PATH%"
)
echo Starting OnlyFreshers local server...
echo.
echo Local URL:   http://localhost:8000
for /f "tokens=2 delims=:" %%A in ('ipconfig ^| findstr /c:"IPv4 Address"') do (
    set "LOCAL_IP=%%A"
)
set "LOCAL_IP=%LOCAL_IP: =%"
if defined LOCAL_IP (
    echo Network URL: http://%LOCAL_IP%:8000
    set "APP_URL=http://%LOCAL_IP%:8000"
    set "VITE_DEV_ORIGIN=http://%LOCAL_IP%:5173"
) else (
    echo Network URL: run ipconfig and use your Wi-Fi IPv4 with :8000
)
echo.
echo Keep this window open while testing the application.
echo.
composer run dev
