<?php
class LimitRequests
{
    public static function checkRateLimit($maxRequestsPerMinute)
    {
        session_start();

        $currentTime = time();

        // Initialize the request count if it doesn't exist in the session
        if (!isset($_SESSION['request_count'])) {
            $_SESSION['request_count'] = 0;
            $_SESSION['request_time'] = $currentTime;
        }

        // Calculate the time difference since the last request
        $timeDifference = $currentTime - $_SESSION['request_time'];

        // If the time difference is greater than 60 seconds (1 minute), reset the request count and update the request time
        if ($timeDifference > 60) {
            $_SESSION['request_count'] = 0;
            $_SESSION['request_time'] = $currentTime;
        }

        // Increment the request count
        $_SESSION['request_count']++;

        // Check if the request count exceeds the maximum allowed
        if ($_SESSION['request_count'] > $maxRequestsPerMinute) {
            // Return false indicating rate limit exceeded
            return false;
        }

        // Rate limit not exceeded
        return true;
    }
}