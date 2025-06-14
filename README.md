# AnimeMonkey

AnimeMonkey is a web application built on top of the Laravel PHP framework, providing a robust platform for managing, discovering, or showcasing anime content. This project leverages the power and flexibility of Laravel's ecosystem, integrating modern PHP practices and frontend tools for an efficient and developer-friendly workflow.

## Features

- Built with [Laravel](https://laravel.com/) for a solid backend foundation
- Clean and modular directory structure (`app/`, `routes/`, `resources/`, `public/`, etc.)
- Uses Composer for PHP dependency management
- Frontend assets managed via Vite, Tailwind CSS, and PostCSS
- Ready-to-use configuration for environment variables and local development
- Includes PHPUnit for automated backend testing

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js (for frontend asset building)
- MySQL, PostgreSQL, or supported database

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/jaltiyassine/animemonkey.git
   cd animemonkey
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Copy the example environment file and update credentials:**
   ```bash
   cp .env.example .env
   # Edit the .env file as needed
   ```

5. **Generate an application key:**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations (if database is set up):**
   ```bash
   php artisan migrate
   ```

7. **Build frontend assets:**
   ```bash
   npm run build
   ```

8. **Start the development server:**
   ```bash
   php artisan serve
   ```

## Directory Structure

- `app/` - Laravel application core (models, controllers, etc.)
- `routes/` - Web and API route definitions
- `resources/` - Views, frontend assets, and language files
- `public/` - Web root and entry point for the app
- `config/` - Application configuration files
- `database/` - Migrations, factories, and seeders

## Testing

Run backend tests with:
```bash
phpunit
# or
php artisan test
```

## Contributing

Pull requests and contributions are welcome! Please fork the repository and submit a PR.

## License

AnimeMonkey is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

> _This project is managed by [jaltiyassine](https://github.com/jaltiyassine). For questions, bug reports, or feature requests, please open an issue on the GitHub repository._