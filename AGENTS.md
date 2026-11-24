# Repository Guidelines

## Project Structure & Module Organization

Whodoku is a PHP 8.5 Composer library for Laravel, with a Vue 3 and TypeScript frontend. Package code lives in `src/` under the `Whodoku\` namespace. Routes are in `routes/`; package configuration, migrations, and seeders are in `config/` and `database/`. Blade views live in `resources/views/`, while frontend code and tests live in `resources/whodoku/`. Public fonts, icons, and built assets are in `public/`. The local Laravel host is in `dev-app/`; container definitions are in `docker/` and `docker-compose.yml`.

## Build, Test, and Development Commands

Run commands from the repository root with Docker Compose and Make installed:

- `make setup` installs dependencies, builds assets, migrates and seeds the local database, and starts the application at `http://localhost:8088/game`.
- `make up` and `make down` start and stop the local services; stopping preserves the database volume.
- `make test` runs PHPUnit unit and integration tests. Run `make setup` first.
- `make frontend-test` runs Vitest, Vue type checking, and ESLint.
- `make build` rebuilds and publishes assets to the local host.

## Coding Style & Naming Conventions

Follow existing Laravel and PHP conventions: four-space indentation, `PascalCase` class names, `camelCase` methods, and PSR-4 paths under `src/`. Use the existing Vue and TypeScript conventions and keep components focused. Run the frontend lint and type checks before submitting changes. Regenerate `dark.css` using `npm run dark:whodoku` when changing the source styles it derives from.

## Testing Guidelines

PHPUnit tests belong in `tests/Unit/` or `tests/Integration/` and use the `*Test.php` suffix. Frontend Vitest files use `*.test.ts` under `resources/whodoku/js/`. Test observable behavior and add regression coverage for fixes. Integration tests use the local development database; avoid destructive operations or assumptions about existing user data. No coverage threshold is currently configured.

## Commits & Pull Requests

No Git history is available here to establish a commit convention. Use focused commits with descriptive subjects. Pull requests should explain the behavior changed, list the checks run, link relevant issues when available, and include screenshots for visible UI changes.

## Configuration & Safety

The local app uses development-only credentials and must not be deployed as production. Keep secrets and generated local data out of version control. Preserve existing migration filenames and do not modify SelfBio or production as part of package work without an explicit request.
