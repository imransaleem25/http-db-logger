# Changelog

All notable changes to this project will be documented in this file.

## [2.0.0] - 2026-03-17

### Breaking
- Require PHP 8.3 or higher (dropped PHP 7.4–8.2)
- Require Laravel 10, 11, or 12 (dropped Laravel 8 and 9)

### Fixed
- Response logging now reads `http-db-logger.log_api_response` and `http-db-logger.log_web_response`
- Migration fallback table name aligned with config default (`http_db_logs`)

### Changed
- Middleware uses typed `Request` / `Response` and nullsafe operator
- Service provider methods declare `: void` return types
- README updated for Laravel 11+ middleware registration and correct schema docs

## [1.0.1] - 2025-09-24

- Config options for storing request/response bodies in the database

## [1.0.0] - 2025-07-30

- Initial release
