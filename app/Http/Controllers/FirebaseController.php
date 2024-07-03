<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{
    public function getData()
    {
        // Initialize Firebase with credentials
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        // Get Firebase Database instance
        $database = $factory->createDatabase();

        // Get reference to the 'sensors' node
        $sensorsRef = $database->getReference('sensors');

        // Read data from Firebase
        $sensorData = $sensorsRef->getValue();

        // Return data as JSON response
        return response()->json($sensorData);
    }
}

