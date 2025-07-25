# Nextwork Laravel Project

## Project Overview
This is a Laravel-based social networking platform called Nextwork. It features user authentication, posts, comments, connections, chat messaging, and a modern dashboard UI. The project is designed for easy local setup and review.

## Requirements
- PHP 8.1 or higher
- Composer
- Node.js & npm
- SQLite (or another supported database)

## Installation & Setup
1. **Unzip the project folder.**
2. Open a terminal in the project root directory.
3. Run `composer install` to install PHP dependencies.
4. Run `npm install` to install frontend dependencies.
5. Copy `.env.example` to `.env` and configure your environment variables as needed (for SQLite, default is fine).
6. Run `php artisan key:generate` to set the application key.
7. Run `php artisan migrate --seed` to set up the database and seed with demo data.
8. Run `npm run build` to compile frontend assets.
9. Start the server with `php artisan serve`.
10. Visit `http://localhost:8000` in your browser.

## Using MySQL Database
If you want to use MySQL instead of SQLite:
1. Create a new MySQL database (e.g., `nextwork_db`).
2. Import the provided SQL dump file (e.g., `nextwork_db.sql`) using a tool like phpMyAdmin or the command line:
   - Command line example:
     `mysql -u your_username -p your_database_name < nextwork_db.sql`
3. Update your `.env` file with your MySQL database credentials:
   - `DB_CONNECTION=mysql`
   - `DB_DATABASE=your_database_name`
   - `DB_USERNAME=your_username`
   - `DB_PASSWORD=your_password`
4. Run `php artisan migrate` if needed (skip if the dump already includes all tables).
5. Continue with the rest of the setup steps above.

## Default Accounts
- Demo users are seeded. You can register a new account or use seeded users.

## Features
- User registration & login
- Profile management
- Posting, commenting, and liking
- Connections (friend system)
- Real-time-style chat (no websockets required)
- Dashboard with recent activity and connections
- Responsive, modern UI (Tailwind CSS)

## Notes
- If you use a different database, update `.env` accordingly and run migrations.
- For any issues, check `storage/logs/laravel.log`.
