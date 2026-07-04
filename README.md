# Koro Platform

Modular Laravel 11 monolith built with [nwidart/laravel-modules](https://github.com/nWidart/laravel-modules). Each capability lives in its own module with optional Filament admin and shared REST API.

## Stack

- PHP 8.3+, Laravel 11
- MySQL 8 (Docker) or SQLite locally
- Filament 3 admin panels (per module)
- Laravel Sanctum REST API
- Docker Compose for local development

## Modules

| Module | Path | Admin | Public / API |
|--------|------|-------|--------------|
| **Core** | `Modules/Core` | `/admin/core` — settings, encrypted integrations | Auth foundation |
| **Payments** | `Modules/Payments` | `/admin/payments` — invoices | Webhooks `POST /api/webhooks/{gateway}` |
| **Ecommerce** | `Modules/Ecommerce` | `/admin/ecommerce` — products | Storefront `/shop` |
| **CRM** | `Modules/Crm` | `/admin/crm` — contacts, leads, pipeline | — |
| **CMS** | `Modules/Cms` | `/admin/cms` — pages, media | `/pages/{slug}` |
| **ERP** | `Modules/Erp` | `/admin/erp` — inventory, orders | — |
| **API** | `Modules/Api` | — | Sanctum REST `/api/v1/*` |

Integration credentials (Stripe, etc.) are stored **encrypted in the database** via the Core module. `.env` should only contain `APP_KEY` and database connection settings.

## Quick start (Docker)

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Open [http://localhost:8080](http://localhost:8080)

**Demo admin:** `admin@koro.test` / `password`

## Quick start (local)

```bash
cp .env.example .env
composer install
php artisan key:generate
# set DB_CONNECTION=sqlite and touch database/database.sqlite if preferred
php artisan migrate --seed
php artisan serve
```

## API (Sanctum)

```bash
curl -X POST http://localhost:8080/api/v1/auth/login \
  -H 'Content-Type: application/json' \
  -d '{"email":"admin@koro.test","password":"password","device_name":"cli"}'
```

Use the returned token as `Authorization: Bearer {token}` for `/api/v1/products`, `/invoices`, `/contacts`, `/pages`, `/inventory`.

## Git workflow

- `main` — stable releases
- `dev` — integration branch
- `feature/*` — module work (e.g. `feature/payments-webhooks`)
- [Conventional Commits](https://www.conventionalcommits.org/) — `feat(ecommerce): add cart checkout`

## Documentation

See [`docs/architecture.md`](docs/architecture.md) for module boundaries and data flow.

See [`docs/DEPLOYMENT.md`](docs/DEPLOYMENT.md) for the Docker-first production checklist.

## Live demo

**URL:** _Pending deployment_ — [GitHub](https://github.com/koro-manoj/koro-platform)

## License

MIT
