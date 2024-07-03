<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class NotifController extends Controller
{
    protected $firebase;

    public function connect()
    {
        $firebase = (new Factory)
                    ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                    ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));
                    
        return $firebase->createDatabase();
    }

    public function notif()
    {
        // Menghubungkan ke Firebase dan mengambil data dari path 'notifications'
        $users = $this->connect()->getReference('notifications')->getSnapshot()->getValue();

        $notifications = [];
        foreach ($users as $notifId => $notification) {
            $notifications[] = [
                'key' => $notifId,
                'message' => $notification['message'] ?? null,
                'read' => $notification['read'] ?? false,
                'timestamp' => $notification['timestamp'] ?? null,
                'title' => $notification['title'] ?? null,
            ];
        }

        // Mengembalikan tampilan dashboard dengan data notifikasi yang diambil dari Firebase
        return view('dashboard')->with([
            'notifications' => $notifications
        ]);
    }

}
