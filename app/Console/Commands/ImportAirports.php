<?php

namespace App\Console\Commands;

use App\Models\Airport;
use App\Repositories\AirportRepository;
use App\Services\AirportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportAirports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpvms:importairports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Airport Database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = file_get_contents('airports.csv');
        $lines = explode("\n", $file); // this is your array of words
        $bar = $this->output->createProgressBar(count($lines));
        DB::disableQueryLog();
        $bar->start();
        foreach($lines as $line) {
            $rec = explode(",", $line);
            $airport = Airport::firstOrNew([
                'id' => $rec[0],
                'icao' => $rec[0]
            ]);
            $airport->name = $rec[1];
            $airport->lat = $rec[2];
            $airport->lon = $rec[3];
            $airport->country = $rec[4];
            $airport->location = $rec[5];
            $airport->iata = $rec[6];
            try {
                $airport->save();
            } catch (\Exception $e) {}
            $bar->advance();
        }
        $bar->finish();
        return Command::SUCCESS;
    }
}
