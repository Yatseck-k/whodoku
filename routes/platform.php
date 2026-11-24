<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use Whodoku\Orchid\Screens\Appearance\AppearanceScreen;
use Whodoku\Orchid\Screens\Catalog\ObjectCatalogScreen;
use Whodoku\Orchid\Screens\Incident\IncidentListScreen;
use Whodoku\Orchid\Screens\Player\PlayerListScreen;
use Whodoku\Orchid\Screens\Puzzle\DifficultyReviewScreen;
use Whodoku\Orchid\Screens\Puzzle\PuzzleDetailsScreen;
use Whodoku\Orchid\Screens\Puzzle\PuzzleGenerationScreen;
use Whodoku\Orchid\Screens\Puzzle\PuzzleListScreen;
use Whodoku\Orchid\Screens\Puzzle\PuzzleMapScreen;
use Whodoku\Orchid\Screens\Puzzle\PuzzleValidationScreen;
use Whodoku\Orchid\Screens\Release\ReleaseScreen;
use Whodoku\Orchid\Screens\Shop\OrderListScreen;
use Whodoku\Orchid\Screens\Skills\SkillSettingsScreen;

// Platform > Release of cases
Route::screen('release', ReleaseScreen::class)
    ->name('platform.release')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Выпуск дел', route('platform.release')));

// Platform > Incidents (reports of players)
Route::screen('incidents', IncidentListScreen::class)
    ->name('platform.incidents')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Обращения игроков', route('platform.incidents')));

// Platform > Orders
Route::screen('orders', OrderListScreen::class)
    ->name('platform.orders')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Заказы', route('platform.orders')));

// Platform > Players
Route::screen('players', PlayerListScreen::class)
    ->name('platform.players')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Игроки', route('platform.players')));

// Platform > Blind check of the difficulty
Route::screen('difficulty', DifficultyReviewScreen::class)
    ->name('platform.difficulty')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Оценка сложности', route('platform.difficulty')));

// Platform > Skills of the detective
Route::screen('skills', SkillSettingsScreen::class)
    ->name('platform.skills')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Навыки детектива', route('platform.skills')));

// Platform > Object catalog
Route::screen('objects', ObjectCatalogScreen::class)
    ->name('platform.objects')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Каталог предметов', route('platform.objects')));

// Platform > Appearance
Route::screen('appearance', AppearanceScreen::class)
    ->name('platform.appearance')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Оформление', route('platform.appearance')));

// Platform > Puzzles > Generate
Route::screen('puzzles/generate', PuzzleGenerationScreen::class)
    ->name('platform.puzzles.generate')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Сгенерировать дело', route('platform.puzzles.generate')));

// Platform > Puzzles
Route::screen('puzzles', PuzzleListScreen::class)
    ->name('platform.puzzles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Дела', route('platform.puzzles')));

// Platform > Puzzles > Puzzle
Route::screen('puzzles/{puzzle}', PuzzleDetailsScreen::class)
    ->name('platform.puzzles.show')
    ->breadcrumbs(fn (Trail $trail, $puzzle) => $trail
        ->parent('platform.puzzles')
        ->push($puzzle->title, route('platform.puzzles.show', $puzzle)));

Route::screen('puzzles/{puzzle}/map', PuzzleMapScreen::class)
    ->name('platform.puzzles.map')
    ->breadcrumbs(fn (Trail $trail, $puzzle) => $trail
        ->parent('platform.puzzles.show', $puzzle)
        ->push('Карта', route('platform.puzzles.map', $puzzle)));

Route::screen('puzzles/{puzzle}/validate', PuzzleValidationScreen::class)
    ->name('platform.puzzles.validate')
    ->breadcrumbs(fn (Trail $trail, $puzzle) => $trail
        ->parent('platform.puzzles.show', $puzzle)
        ->push('Проверка', route('platform.puzzles.validate', $puzzle)));

