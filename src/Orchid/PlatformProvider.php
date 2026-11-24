<?php

declare(strict_types=1);

namespace Whodoku\Orchid;

use Illuminate\Routing\Router;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Whodoku\Models\Incident;

class PlatformProvider extends OrchidServiceProvider
{
    public function routes(Router $router): void
    {
        require __DIR__.'/../../routes/platform.php';
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Игра Whodoku')
                ->icon('bs.controller')
                ->list([
                    Menu::make('Дела')->icon('bs.collection')->route('platform.puzzles')->permission('platform.puzzles.view'),
                    Menu::make('Сгенерировать дело')->icon('bs.dice-5')->route('platform.puzzles.generate')->permission('platform.puzzles.generate'),
                    Menu::make('Каталог предметов')->icon('bs.lamp')->route('platform.objects')->permission('platform.puzzles.objects'),
                    Menu::make('Оформление')->icon('bs.palette')->route('platform.appearance')->permission('platform.puzzles.objects'),
                    Menu::make('Выпуск дел')->icon('bs.calendar-event')->route('platform.release')->permission('platform.puzzles.generate'),
                    Menu::make('Игроки')->icon('bs.person-badge')->route('platform.players')->permission('platform.puzzles.players'),
                    Menu::make('Обращения игроков')->icon('bs.flag')->route('platform.incidents')->permission('platform.puzzles.validate')
                        ->badge(fn () => ($count = Incident::query()->where('status', Incident::NEW)->count()) > 0 ? (string) $count : null),
                    Menu::make('Заказы')->icon('bs.cart')->route('platform.orders')->permission('platform.puzzles.players'),
                    Menu::make('Оценка сложности')->icon('bs.star-half')->route('platform.difficulty')->permission('platform.puzzles.generate'),
                    Menu::make('Навыки')->icon('bs.stars')->route('platform.skills')->permission('platform.puzzles.players'),
                ]),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group('Дела')
                ->addPermission('platform.puzzles.view', 'Просмотр дел')
                ->addPermission('platform.puzzles.edit', 'Редактирование карты')
                ->addPermission('platform.puzzles.validate', 'Проверка дела')
                ->addPermission('platform.puzzles.publish', 'Публикация дел')
                ->addPermission('platform.puzzles.delete', 'Удаление дел')
                ->addPermission('platform.puzzles.generate', 'Генерация дел')
                ->addPermission('platform.puzzles.objects', 'Каталог предметов и оформление')
                ->addPermission('platform.puzzles.players', 'Игроки'),
        ];
    }
}
