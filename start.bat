@echo off
title Creator Academy — Local WordPress
echo.
echo  ╔══════════════════════════════════════════╗
echo  ║   Creator Academy — Starting server...   ║
echo  ╚══════════════════════════════════════════╝
echo.
echo  Site:   http://localhost:8080
echo  Admin:  http://localhost:8080/wp-admin
echo  Login:  admin / password
echo.
echo  Press Ctrl+C to stop the server.
echo.
timeout /t 2 /nobreak >nul
start "" "http://localhost:8080"
cd /d "%~dp0wp-content\themes\creator-academy"
npx @wp-now/wp-now start --port=8080
