# Intermediate PHP Todo App

An intermediate PHP practice project with a lightweight router, MVC-like structure, JSON persistence, and simple form handling.

## Features
- Custom routing with query-based path handling
- Controllers and model layer
- JSON-backed data store (`data/todos.json`)
- Create and toggle todo completion
- Server-side rendering with reusable views

## Requirements
- PHP 8.0+
- Built-in server: `php -S localhost:8000`

## Run
1. `cd f:\php\\intermediate-php-app`
2. `php -S localhost:8000`
3. Open `http://localhost:8000`

## File structure
- `index.php` - Entrypoint and setup
- `src/Router.php` - Routing logic
- `src/Controller` - Controller actions
- `src/Model/Todo.php` - Model for todo items
- `views/` - HTML templates
- `data/todos.json` - sample data store
