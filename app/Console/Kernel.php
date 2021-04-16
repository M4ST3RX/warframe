<?php

namespace App\Console;

use App\Console\Commands\CreateWarframeCrafting;
use App\Console\Commands\InsertResources;
use App\Console\Commands\WeaponCraftingRecipes;
use App\Console\Commands\ItemScraper;
use App\Console\Commands\WarframeCraftingRecipes;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateWarframeCrafting::class,
        InsertResources::class,
        ItemScraper::class,
        WarframeCraftingRecipes::class,
        WeaponCraftingRecipes::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
