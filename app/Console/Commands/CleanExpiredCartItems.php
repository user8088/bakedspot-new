<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanExpiredCartItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove cart items associated with expired sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the session lifetime in minutes from config
        $sessionLifetime = config('session.lifetime');
        $this->info("Session lifetime is set to: {$sessionLifetime} minutes");

        // Calculate the cutoff time (current time minus session lifetime)
        $cutoffTime = Carbon::now()->subMinutes($sessionLifetime);
        $this->info("Cutoff time is: {$cutoffTime}");

        // Get all session files
        $sessionPath = storage_path('framework/sessions');
        $sessionFiles = File::files($sessionPath);

        $activeSessions = [];
        foreach ($sessionFiles as $file) {
            $lastModified = Carbon::createFromTimestamp(File::lastModified($file));
            if ($lastModified->gt($cutoffTime)) {
                // This is an active session, keep its ID
                $sessionId = str_replace('sess_', '', $file->getFilename());
                $activeSessions[] = $sessionId;
            }
        }

        $this->info("Found " . count($activeSessions) . " active sessions");

        // Delete cart items for sessions that are not in the active sessions list
        $deletedCount = DB::table('carts')
            ->whereNotIn('session_id', $activeSessions)
            ->delete();

        $this->info("Successfully deleted {$deletedCount} cart items from expired sessions.");
    }
}
