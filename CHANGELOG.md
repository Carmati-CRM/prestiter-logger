# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-03-13

### Added

- Initial release
- `LogEntry` value object with required and optional fields
- `DriverInterface` for implementing custom drivers
- `NewRelicDriver` for sending logs to New Relic Log API
- `FileDriver` for writing logs to files in JSON Lines format
- `NullDriver` for testing environments
- `Logger` class with support for multiple drivers
- Convenience methods: `info()`, `warn()`, `error()`, `debug()`
- Automatic timestamp (ms UTC) and environment detection
- PHPStan and Psalm static analysis at maximum strictness
- PHP_CodeSniffer and PHP-CS-Fixer for code style
- PHPUnit test suite
