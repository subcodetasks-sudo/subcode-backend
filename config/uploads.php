<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Maximum upload size (kilobytes)
    |--------------------------------------------------------------------------
    |
    | Used by Filament FileUpload, API validation, and documentation hints.
    | Default: 1 GB (1024 * 1024 KB).
    |
    */

    'max_kb' => (int) env('UPLOAD_MAX_KB', 1024 * 1024),

];
