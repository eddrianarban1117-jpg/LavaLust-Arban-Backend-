# LavaLust Lab 6 Product API

This repository contains the LavaLust framework files required by the Lab 6 Product Management API. The React frontend remains in its own repository. Lab 5 web controllers, views, and routes are intentionally excluded.

## API routes

- `POST /api/login`
- `POST /api/refresh`
- `POST /api/logout`
- `GET /api/products`
- `GET /api/products/{id}`
- `POST /api/products`
- `PUT /api/products/{id}`
- `DELETE /api/products/{id}`

Product routes require an access JWT in the `Authorization: Bearer <token>` header. Login returns access and refresh tokens.

## Render environment

Use the Docker runtime and set these variables in the Render service environment settings. Do not commit a `.env` file or put credential values in source code.

- `DB_HOST`
- `DB_PORT`
- `DB_USER`
- `DB_PASSWORD`
- `DB_NAME`
- `JWT_SECRET` (at least 32 random characters)
- `REFRESH_TOKEN_KEY` (at least 32 random characters)
- `API_ADMIN_USERNAME`
- `API_ADMIN_PASSWORD_HASH` (a PHP `password_hash()` result)
- `DB_SSL_CA` (optional; defaults to the included `ca.pem`)
- `APP_ENV` (set to `production`)
- `PORT` (set to `80` because the included Apache image listens on port 80)

The database user must have access to the `products` and `refresh_tokens` tables. The included migration files describe the schema; the migration system is disabled by default. Do not enable or run migrations against a production database until you have confirmed its schema and backup.

## Local run

With PHP 8.3+, PDO MySQL, and Apache rewrite support available, configure the environment variables above and run:

```powershell
php -S 127.0.0.1:8080 -t public
```

The React development origin `http://localhost:5173` and deployed frontend origin are allowed by the API CORS configuration.

## Docker

Render should build this directory using the included `Dockerfile`. Apache serves `public/`; `.dockerignore` keeps local environment files and Git metadata out of the image build context.
