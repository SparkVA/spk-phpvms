<?php

namespace App\Console\Commands;

use App\Models\Enums\UserState;
use App\Models\Subfleet;
use App\Models\User;
use App\Services\AirportService;
use App\Services\UserService;
use App\Support\Units\Time;
use App\Support\Utils;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EliteImport extends Command
{

    public function __construct(public AirportService $airportService)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:elite-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // First, import all the user accounts
        $theCSV = array_map('str_getcsv', file("elite_users.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        /*Walk through the array and combine the headers which is the first element of our csv array with the rest of the csv data*/
        array_walk($theCSV, function(&$ary) use($theCSV) {
            $ary = array_combine($theCSV[0], $ary);
        });
        //remove column headers which is the first element
        array_shift($theCSV);
        foreach ($theCSV as $nu) {
            // search the users for email to see if we have the account or not.
            $user = User::where('email', $nu['email'])->first();
            // Check if airport needs to be added
            $this->airportService->lookupAirportIfNotFound($nu['hub']);
            if (!is_null($user)) {
                //$user->awards()->attach(3);
                $user->country = strtolower($user->country);
                $user->save();
                continue;
            }

            //// New user!!!
            //$attrs = [
            //    'name'            => $nu['firstname'].' '.$nu['lastname'],
            //    'email'           => $nu['email'],
            //    'password'        => Hash::make(Str::random(60)),
            //    'api_key'         => Utils::generateApiKey(),
            //    'airline_id'      => 7,
            //    'rank_id'         => 1,
            //    'home_airport_id' => $nu['hub'],
            //    'curr_airport_id' => $nu['hub'],
            //    'country'         => $nu['location'],
            //    'flights'         => (int) 0,
            //    'flight_time'     => Time::hoursToMinutes(0),
            //    'state'           => UserState::ACTIVE,
            //    'created_at'      => Carbon::parse($nu['joindate']),
            //];
            //User::create($attrs);
        }
        // now, create the fleet
        // First, import all the user accounts
        //$fleet_csv = array_map('str_getcsv', file("elite_fleet.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        ///*Walk through the array and combine the headers which is the first element of our csv array with the rest of the csv data*/
        //array_walk($fleet_csv, function(&$ary) use($fleet_csv) {
        //    $ary = array_combine($fleet_csv[0], $ary);
        //});
        ////remove column headers which is the first element
        //array_shift($fleet_csv);
//
        //foreach ($fleet_csv as $old_acf) {
        //    // Check for ETX fleet type.
        //    $sf = Subfleet::firstOrCreate(['type' => 'ETX-'.$old_acf['icao']], [
        //        'name' => $old_acf['fullname'],
        //        'airline_id' => 7
        //    ]);
        //    $sf->aircraft()->create([
        //        'icao' => $old_acf['icao'],
        //        'name' => $old_acf['name'],
        //        'registration' => $old_acf['registration'],
        //    ]);
        //}
    }
}
