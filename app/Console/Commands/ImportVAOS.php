<?php

namespace App\Console\Commands;

use App\Models\Aircraft;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Enums\PirepState;
use App\Models\Enums\PirepStatus;
use App\Models\Enums\UserState;
use App\Models\Flight;
use App\Models\Pirep;
use App\Models\Role;
use App\Models\Subfleet;
use App\Models\User;
use App\Models\UserField;
use App\Models\UserFieldValue;
use App\Models\VAOS\Schedule;
use App\Support\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportVAOS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpvms:import_vaos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a VAOS 2.0 public\smartcars\0.2.1\handlers\phpvms5\assets\database data into this system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // Star the public\smartcars\0.2.1\handlers\phpvms5\assets\database import
        // First, get all the tables we need.
        DB::setDefaultConnection('vaos');
        $users = DB::table('users')->get();
        $airports = DB::table('airports')->get();
        $schedules = Schedule::with('depapt', 'arrapt', 'airline', 'aircraft_group', 'aircraft')->get();
        $aircraft_groups = DB::table('aircraft_groups')->get();
        $airlines = DB::table('airlines')->get();
        $fleet = DB::table('aircraft')->get();
        //$flights = \App\Models\VAOS\Flight::with('depapt', 'arrapt', 'aircraft', 'user')->where(['state' => 2])->get();
        $this->info("All the data has been pulled");
        // Now, start building out the public\smartcars\0.2.1\handlers\phpvms5\assets\database.
        DB::setDefaultConnection('mysql');
        /*
        foreach ($airports as $airport) {
            $apt = Airport::firstOrNew(['id' => $airport->icao], [
                'icao' => $airport->icao,
                'name' => $airport->name,
                'lat'  => $airport->lat,
                'lon'  => $airport->lon,
            ]);
            $apt->save();
        }
        $this->info("Airports Imported");
        // Airline Time.. Merge the IDs.
        foreach ($airlines as $airline) {
            $apt = Airline::firstOrNew(
                [
                'id' => $airline->id],
                [
                'icao'     => $airline->icao,
                'name'     => $airline->name,
                'callsign' => $airline->callsign]
            );
            $apt->save();
        }
        $this->info("Airlines Imported");

        // Aircraft time... Now we get into some complicated shit...
        // First thing's first, we need to create subfleets for each type of aircraft...

        foreach ($aircraft_groups as $group) {
            $sf = new Subfleet();
            $sf->id = $group->id;
            $sf->name = $group->name;
            $sf->airline_id = $group->airline_id;
            $sf->type = $group->icao;
            $sf->save();
        }
        $this->info("Aircraft Subfleets Created");
        // Now, do the aircraft.
        // Get all the subfleets.
        $subfleets = Subfleet::all();

        foreach ($fleet as $aircraft) {
            // Get the subfleet:
            $acf = new Aircraft();
            $acf->id = $aircraft->id;
            $acf->name = $aircraft->name;
            $acf->icao = $aircraft->icao;
            // check if multiple registrations...
            if (Aircraft::where('registration', $aircraft->registration)->first()) {
                $acf->registration = $aircraft->registration."_".Utils::generateNewId(4);
            } else {
                $acf->registration = $aircraft->registration;
            }
            // Personal Aircraft Check
            if (is_null($aircraft->airline_id)) {
                continue;
            // Check if we have a airline for the user...
            // $user = $users->where('id', $aircraft->user_id)->first();
            // $airline = Airline::where('name', "$user->first_name $user->last_name's Personal Hangar")->first();
            // if (is_null($airline)) {
                //     $airline = new Airline();
                //     $airline->icao = "P{$user->id}";
                //     $airline->name = "$user->first_name $user->last_name's Personal Hangar";
                //     $airline->save();
            // }
            // // Check if the subfleet exists for this type. If not, create it.
            // $sf = Subfleet::where(['airline_id' => $airline->id, 'type' => $aircraft->icao])->first();
            // if (is_null($sf)) {
                //     $sf = new Subfleet();
                //     $sf->name = $aircraft->name;
                //     $sf->airline_id = $airline->id;
                //     $sf->type = $aircraft->icao;
                //     $sf->save();
            // }
            // $acf->subfleet()->associate($sf);
            } else {
                $acf->subfleet()->associate(Subfleet::where(['airline_id' => $aircraft->airline_id, 'type' => $aircraft->icao])->first());
            }
            $acf->save();
        }
        $this->info("Aircraft Imported");

        // Schedule Time!!!
        foreach ($schedules as $schedule) {
            $sflt = new Flight(); // uuuggghhh... This naming is fucking STUPID
            $sflt->airline()->associate($schedule->airline_id);
            $sflt->flight_number = $schedule->flightnum;
            $sflt->dpt_airport()->associate($schedule->depapt->icao);
            $sflt->arr_airport()->associate($schedule->arrapt->icao);
            $sflt->save();

            // Attach subfleets based on existing fleet options
            foreach ($schedule->aircraft_group as $group) {
                $sflt->subfleets()->attach($group->id);
            }
        }
        // Create VATSIM ID User Field
        $vid = new UserField();
        $vid->name = "VATSIM CID";
        $vid->show_on_registration = true;
        $vid->save();
        // VAOS Username
        $vid = new UserField();
        $vid->name = "VAOS Username";
        $vid->show_on_registration = false;
        $vid->save();
        // Time to add user accounts!!!
        */
        $userFields = UserField::all();
        foreach ($users as $user) {
            $nu = User::firstOrNew(['email' => $user->email]);
            //if (is_null($nu)) {
                //$nu = new User();
                $nu->name = "$user->first_name $user->last_name";
                $nu->email = $user->email;
                $nu->state = UserState::ACTIVE;
                $nu->password = $user->password;
                $nu->curr_airport_id = "KLAX";
                $nu->home_airport_id = "KLAX";
                $nu->rank_id = 1;
                $nu->country = 'us';
                $nu->created_at = $user->created_at;
                $nu->airline()->associate(Airline::find(1));
                $nu->save();
                //if ($user->admin) {
                //    $nu->roles()->attach(1);
                //}

                // VATSIM ID
                UserFieldValue::updateOrCreate([
                    'user_field_id' => $userFields->firstWhere('name', 'VATSIM CID'),
                    'user_id'       => $nu->id,
                ], ['value' => $user->vatsim]);
                // VAOS Username
                UserFieldValue::updateOrCreate([
                    'user_field_id' => $userFields->firstWhere('name', 'VAOS Username'),
                    'user_id'       => $nu->id,
                ], ['value' => $user->username]);

            //}
        }
        // Add all flight history
        /*
        foreach($flights as $flight) {
            $pirep = new Pirep();
            // Resolve the airline ID based on the aircraft and callsign in the new public\smartcars\0.2.1\handlers\phpvms5\assets\database
            $pirep->airline()->associate(!$flight->airline_id ? 1 : $flight->airline_id);
            if ($flight->flightnum)
                $pirep->flight_number = $flight->flightnum;
            else
                $pirep->flight_number = $flight->callsign;
            $pirep->user()->associate($flight->user_id);
            $pirep->dpt_airport()->associate($flight->depapt->icao);
            $pirep->arr_airport()->associate($flight->arrapt->icao);

            $pirep->aircraft()->associate(Aircraft::where(['registration' => $flight->aircraft->registration])->first());
            $pirep->landing_rate = $flight->landingrate;
            $pirep->state = PirepState::ACCEPTED;
            $pirep->status = PirepStatus::ARRIVED;
            $pirep->save();
        }
        */
        return 0;
    }
}
