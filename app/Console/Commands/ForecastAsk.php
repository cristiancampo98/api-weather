<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\OpenWeatherMapService;

class ForecastAsk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:ask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ask for forecast parameters and get the weather forecast';

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
        $days = $this->ask('How many days to forecast?', 1);
        $units = $this->choice('What unit of measure?', ['metric', 'imperial'], 0);

        if (intval($days) > 5) {
            $days = 5;
        }
        
        $location = 'Santander,ES';
        [$city, $country] = explode(',', $location);
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
