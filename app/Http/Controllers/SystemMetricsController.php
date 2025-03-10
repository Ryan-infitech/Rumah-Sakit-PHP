<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class SystemMetricsController extends Controller
{
    /**
     * Get system metrics for dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSystemMetrics()
    {
        // For demo purposes, we'll generate simulated metrics
        // In a real production environment, you would use actual server metrics
        
        // Simulated CPU usage - random value between 10-50%
        $cpuUsage = rand(10, 50);
        
        // Simulated memory usage - random value between 100-500 MB
        $memoryUsage = rand(100, 500);
        
        // Simulated DB queries in last 5s - random value between 5-25
        $dbQueries = rand(5, 25);
        
        // Get active connections from database
        $dbConnections = $this->getDatabaseConnections();
        
        // Get simulated server uptime
        $uptime = $this->getSimulatedUptime();
        
        // Update the current user's last activity timestamp
        $this->updateUserActivity();
        
        // Get online users (active in the last 5 minutes)
        $onlineUsers = $this->getOnlineUsers();
        
        // Get total users 
        $totalUsers = User::count();
        
        // Get recent active users - only those really online
        $activeUserDetails = $this->getActiveUserDetails();
            
        // Get total active sessions
        $totalSessions = count($onlineUsers);
        
        return response()->json([
            'cpu_usage' => $cpuUsage,
            'memory_usage' => $memoryUsage,
            'db_queries' => $dbQueries,
            'db_connections' => $dbConnections,
            'uptime' => $uptime,
            'active_users' => $totalSessions,
            'total_users' => $totalUsers,
            'active_user_details' => $activeUserDetails,
            'total_sessions' => $totalSessions,
            'timestamp' => now()->format('H:i:s')
        ]);
    }
    
    /**
     * Update the current user's last activity timestamp
     */
    private function updateUserActivity()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Cache::put('user-online-' . $user->id, true, now()->addMinutes(5));
        }
    }
    
    /**
     * Get list of online users
     *
     * @return array
     */
    private function getOnlineUsers()
    {
        // Get all users
        $users = User::all();
        $onlineUsers = [];
        
        foreach ($users as $user) {
            if (Cache::has('user-online-' . $user->id)) {
                $onlineUsers[] = $user;
            }
        }
        
        return $onlineUsers;
    }
    
    /**
     * Get details of active users
     *
     * @return array
     */
    private function getActiveUserDetails()
    {
        $onlineUsers = $this->getOnlineUsers();
        
        $details = [];
        foreach ($onlineUsers as $user) {
            $details[] = [
                'name' => $user->nama_user,
                'role' => ucfirst($user->roles),
                'last_seen' => Carbon::now()->diffForHumans(),
            ];
        }
        
        return $details;
    }
    
    /**
     * Get database connections count
     *
     * @return int
     */
    private function getDatabaseConnections()
    {
        // For demo purposes, we'll return a simulated value
        // In a real production environment, you could use:
        // $result = DB::select('SHOW STATUS WHERE Variable_name = "Threads_connected"');
        // return (int) $result[0]->Value;
        
        return rand(2, 15);
    }
    
    /**
     * Get simulated server uptime
     *
     * @return string
     */
    private function getSimulatedUptime()
    {
        // Cache a start time if it doesn't exist
        if (!Cache::has('server_start_time')) {
            Cache::put('server_start_time', now()->subDays(rand(1, 30))->subHours(rand(1, 24)), now()->addDays(30));
        }
        
        $startTime = Cache::get('server_start_time');
        $diff = $startTime->diff(now());
        
        return $diff->format('%d days, %h hours, %i minutes');
    }
}
