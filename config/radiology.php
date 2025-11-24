<?php

return [
    // UNC path untuk Windows atau mount point untuk Linux
    'mount_path' => env('RADIOLOGY_MOUNT', '//192.168.99.4/file sharing'),

    // Database connection (opsional)
    'connection' => env('DB_CONNECTION', null),
];
