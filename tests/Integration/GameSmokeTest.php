<?php

declare(strict_types=1);

namespace Tests\Integration;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Whodoku\Application\Player\PlayerSkills;
use Whodoku\Models\Player;
use Whodoku\Models\Puzzle;
use Whodoku\Orchid\PlatformProvider;

class GameSmokeTest extends TestCase
{
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../../dev-app/bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function test_game_page_loads_with_its_built_assets(): void
    {
        $this->get('/game')->assertOk()
            ->assertSee('build/whodoku/assets/', false)
            ->assertSee('killdoku-theme', false)
            ->assertDontSee('локальная разработка');
    }

    public function test_host_can_choose_its_own_game_template(): void
    {
        config(['whodoku.root_view' => 'whodoku']);

        $this->get('/game')->assertOk()->assertSee('локальная разработка');
    }

    public function test_catalog_api_responds(): void
    {
        $connectionDuringGameQuery = null;
        DB::listen(function ($query) use (&$connectionDuringGameQuery): void {
            if ($query->connectionName === 'whodoku') {
                $connectionDuringGameQuery = DB::getDefaultConnection();
            }
        });
        $response = $this->getJson('/api/puzzles')->assertOk()->assertJsonStructure(['data', 'solved', 'locked']);
        $this->assertSame('pgsql', $connectionDuringGameQuery);
        $this->assertNotEmpty($response->json('data'));
        $slug = $response->json('data.0.slug');
        $this->get('/puzzles/'.$slug)->assertOk();
        $this->getJson('/api/puzzles/'.$slug)->assertOk();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
        $this->postJson('/api/puzzles/'.$slug.'/check', [])->assertUnprocessable();
    }

    public function test_orchid_routes_can_be_added_to_the_hosts_private_group(): void
    {
        Route::prefix('admin')->middleware('auth')->group(function (): void {
            (new PlatformProvider($this->app))->routes($this->app['router']);
        });

        Route::getRoutes()->refreshNameLookups();
        $route = Route::getRoutes()->getByName('platform.puzzles');
        $this->assertNotNull($route);
        $this->assertSame('admin/puzzles/{method?}', $route->uri());
        $this->assertContains('auth', $route->gatherMiddleware());
    }

    public function test_game_models_and_transactions_use_the_game_connection(): void
    {
        $this->assertSame('pgsql', DB::getDefaultConnection());
        $this->assertGreaterThan(0, Puzzle::query()->count());

        $game = DB::connection('whodoku');
        $game->beginTransaction();
        try {
            $player = Player::query()->create(['telegram_id' => -random_int(1000000000, 2000000000), 'points' => 10000]);
            $levelDuringUpdate = null;
            Player::updating(function () use ($game, &$levelDuringUpdate): void {
                $levelDuringUpdate = $game->transactionLevel();
            });

            $this->assertTrue(app(PlayerSkills::class)->allocate($player, 'intellect'));
            $this->assertSame(2, $levelDuringUpdate);
            $this->assertSame(1, $player->fresh()->skills['intellect']);
            $this->assertSame('pgsql', DB::getDefaultConnection());
        } finally {
            $game->rollBack();
        }
    }

    public function test_player_can_sign_in_without_changing_the_host_connection(): void
    {
        config(['services.telegram.dev_login' => true]);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
        $game = DB::connection('whodoku');
        $game->beginTransaction();
        try {
            $this->postJson('/player/login/dev', ['id' => 9274, 'name' => 'Тест'])
                ->assertOk()->assertJsonPath('player.first_name', 'Тест');
            $this->getJson('/player/me')->assertOk()->assertJsonPath('player.first_name', 'Тест');
            $this->assertSame('pgsql', DB::getDefaultConnection());
        } finally {
            $game->rollBack();
        }
    }
}
