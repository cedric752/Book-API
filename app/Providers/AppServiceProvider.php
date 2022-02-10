<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Symfony\Component\HttpFoundation\Request;
use Knuckles\Scribe\Scribe;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Be sure to wrap in a `class_exists()`, 
        // so production doesn't break if you installed Scribe as dev-only
        if (class_exists(\Knuckles\Scribe\Scribe::class)) {
            Scribe::beforeResponseCall(function (Request $request, ExtractedEndpointData $endpointData) {
                $user = User::where('role_id', 2)->first();
                $token = $user->createToken('myapptoken')->plainTextToken;
                $request->headers->add(["Authorization" => "Bearer $token"]);
            });
        }

        DB::listen(function ($event) {
            $bindings = $event->bindings;
            $time = $event->time;
            $query = $event->sql;
            $data = compact('bindings', 'time');
            // Format binding data for sql insertion
            foreach ($bindings as $i => $binding) {
                if (is_object($binding) && $binding instanceof \DateTime) {
                    $bindings[$i] = '\'' . $binding->format('Y-m-d H:i:s') . '\'';
                } elseif (is_null($binding)) {
                    $bindings[$i] = 'NULL';
                } elseif (is_bool($binding)) {
                    $bindings[$i] = $binding ? '1' : '0';
                } elseif (is_string($binding)) {
                    $bindings[$i] = "'{$binding}'";
                }
            }
            $query = preg_replace_callback('/\\?/', function () use(&$bindings) {
                return array_shift($bindings);
            }, $query);
            Log::info($query, $data);
        });

        
    }
}
