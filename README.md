# JTL Lizenzmanagement App
Eine einfache Laravel MVC-App für Lizenzmanagement.

# Voraussetzungen
PHP 8.0 oder höher
Composer
MySQL oder SQLite

# Projekt einrichten
cd jtl-license-management

# Abhängigkeiten installieren
composer install

# Datenbank einrichten
SQLite Datenbankdatei erstellen
touch database/database.sqlite

Für MySQL:
.env Datei anpassen
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jtl_licenses
DB_USERNAME=root
DB_PASSWORD=start123

# Datenbank migrieren
php artisan migrate

# Entwicklungsserver starten
php artisan serve


# App öffnen
http://localhost:8000/licenses

# Routes anzeigen
php artisan route:list