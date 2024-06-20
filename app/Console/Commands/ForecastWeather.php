<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\OpenWeatherMapService;

class ForecastWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast {location=Santander,ES} {--d|days=1} {--u|units=metric}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the weather forecast for the given location';

    protected $weatherService;

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
        $days = $this->option('days');
        $units = $this->option('units');

        if (intval($days) > 5) {
            $days = 5;
        }
        
        $forecast = $this->weatherService->getForecast($city, $country, $days, $units);

        $this->info("{$city} ({$country})");
        foreach ($forecast['list'] as $key => $day) {
            if ($key == $days) break;
            $date = Carbon::createFromTimestamp($day['dt'])->format('M d, Y');
            $this->info("{$date}");
            $this->info("> Weather: {$day['weather'][0]['description']}");
            $this->info("> Temperature: {$day['temp']['day']} °" . strtoupper(substr($units, 0, 1)));
        }
    }
}
