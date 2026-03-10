<?php

// Features configuration for Mobile API
return [
    'show_onboarding' => env('FEATURE_SHOW_ONBOARDING', true),
    'show_notifications' => env('FEATURE_SHOW_NOTIFICATIONS', true),
    'enable_location_tracking' => env('FEATURE_LOCATION_TRACKING', true),
];

