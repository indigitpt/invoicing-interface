## Invoicing Interface Package

This is a Laravel package (`indigitpt/invoicing-interface`) that provides a standardized API interface between a Laravel application and an external invoicing platform (e.g., Moloni). It handles document lifecycle management for payments, refunds, orders, and withdrawals.

### Architecture

- **Contract-based**: All document handlers must implement `DocumentInterface` — the consuming application provides concrete implementations.
- **DTO-driven**: Uses `spatie/laravel-data` for type-safe data transfer objects. All DTOs live in `src/Data/`.
- **Enum-routed**: `DocumentTypeEnum` drives routing — the main `Invoicing` class uses `match` expressions to dispatch to the correct handler.
- **Bearer token auth**: API endpoints are protected via a custom `Authenticate` middleware that validates against `config('invoicing.api-key')`.

### Conventions

- PHP 8.5+ features should be used: pipe operator (`|>`), `clone()` with property overrides, `#[\NoDiscard]`, `array_first()`/`array_last()`.
- All source classes use constructor property promotion.
- Data classes extend `Spatie\LaravelData\Data` — do not use Eloquent models for data transfer.
- The package uses `spatie/laravel-package-tools` for service provider scaffolding.
- Tests use Pest PHP with architecture tests.
- Static analysis runs at PHPStan level 8 with Larastan.
- Code formatting uses Laravel Pint.

### Key Patterns

- The `Invoicing` class is the single entry point — it delegates to injected `DocumentInterface` implementations via constructor injection.
- Routes are defined in `routes/api.php` with the prefix `invoicing-interface/api`.
- Configuration is minimal: only an API key from the environment (`INVOICING_API_KEY`).

### What NOT to Do

- Do not add Eloquent models — this package is a transport/interface layer.
- Do not hardcode invoicing provider logic — implementations belong in the consuming application.
- Do not bypass the `DocumentInterface` contract for new document types.
- Do not add complex middleware chains — authentication is intentionally simple (bearer token).
