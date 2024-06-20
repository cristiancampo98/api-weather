<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\OpenWeatherMapService;

class CurrentWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'current {location=Santander,ES} {--units=metric}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current weather data for the given location';

    public function __construct(OpenWeatherMapService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        [$city, $country] = explode(',', $this->argument('location'));
        $units = $this->option('units');
        $weather = $this->weatherService->getCurrentWeather($city, $country, $units);

        $this->info("{$city} ({$country})");
        $this->info(Carbon::now()->format('M d, Y'));
        $this->info("> Weather: {$weather['weather'][0]['description']}");
        $this->info("> Temperature: {$weather['main']['temp']} °" . strtoupper(substr($units, 0, 1)));
    }
}
