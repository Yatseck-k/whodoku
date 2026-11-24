# Whodoku

**A detective logic puzzle game for Laravel. Place guests on a grid, follow the clues, and find the culprit.**

[Русский](README.ru.md) · [Package integration plan (RU)](WORK/WHODOKU_PACKAGE_PLAN.md) · [Development](AGENTS.md)

![PHP](https://img.shields.io/badge/PHP-8.5%2B-777BB4?logo=php&logoColor=white) ![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white) ![Vue](https://img.shields.io/badge/Vue-3-4FC08D?logo=vuedotjs&logoColor=white) [![Checks](https://github.com/Yatseck-k/whodoku/actions/workflows/check.yml/badge.svg?branch=main)](https://github.com/Yatseck-k/whodoku/actions/workflows/check.yml)

## Overview

**Whodoku** is a Composer package for a detective puzzle game. Use witness statements to place guests on a room map, with at most one guest per row and column. The remaining cell holds a clue that helps you identify the culprit.

The repository includes `dev-app`, a Laravel host for running the game and testing the package independently of SelfBio.

## Features

| Area | What it provides |
| --- | --- |
| **Game** | Interactive room grid, witness statements, tutorial, and case catalog |
| **Cases** | Puzzle generation and a guest-accessible demo case in the local app |
| **Player progression** | Detective profile, skills, statistics, and rankings |
| **Package integration** | Laravel package discovery for game routes, configuration, and migrations |
| **Administration** | Optional Orchid provider for game screens, permissions, and a map editor |

## Technology

| Layer | Stack |
| --- | --- |
| **Backend** | PHP 8.5, Laravel 13, Inertia.js 3 |
| **Frontend** | Vue 3, TypeScript, Vite 8 |
| **Database** | PostgreSQL 17 in the local environment |
| **Administration** | Orchid 14 |
| **Development** | Docker Compose, Make, Node.js 24 in the frontend container |

## Quick start

Requires Git, Docker with Compose, and Make.

```bash
git clone https://github.com/Yatseck-k/whodoku.git
cd whodoku
make setup
```

Open [the game](http://localhost:8088/game), [the case catalog](http://localhost:8088/puzzles), or [the rules](http://localhost:8088/rules). Setup installs dependencies, builds and publishes assets, runs migrations, seeds reference data, and creates a guest case if needed. The PostgreSQL volume persists across `make down` and subsequent setup runs.

The local app uses a development key, a local database, and a test player login. Use it for local development only. Set `WHODOKU_UID` and `WHODOKU_GID` if the containers need to run under a different user.

## Development commands

| Command | What it does |
| --- | --- |
| `make up` / `make down` | Start or stop the development services |
| `make build` | Rebuild and publish the frontend assets to the local app |
| `make test` | Run PHPUnit unit and integration tests after `make setup` |
| `make frontend-test` | Run Vitest, Vue type checks, and ESLint |

The integration tests use the local database to check routes such as the game page, catalog, and case page.

## Laravel integration

- The package provider registers the game routes, migrations, and the `killdoku` and `story` configuration. The host provides a database connection named `whodoku` and a `player` guard. See [the local app configuration](dev-app/config).
- The default Inertia root view is `whodoku::whodoku`. Set `whodoku.root_view` to use a host view, for example to add SEO metadata.
- The build produces `public/build/whodoku` with a dedicated Vite manifest for the game and map editor. To publish assets from a built package in the host, run `php artisan vendor:publish --tag=whodoku-assets --force`. This overwrites matching public assets.
- Register `Whodoku\Orchid\PlatformProvider` to enable the private Orchid routes, game menu, and `platform.puzzles.*` permissions. Register the routes through the provider only to avoid duplicates. Some admin actions expect `Whodoku\Models\User` and users in the game schema.

Integration with other Laravel hosts still needs validation, including the database, player guard, Telegram, payments, SEO, and Orchid. See the [package integration plan (RU)](WORK/WHODOKU_PACKAGE_PLAN.md) for the remaining work.
