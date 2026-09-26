<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:biswas', function () {
    $this->comment('Biswas IT Firm lead automation prototype');
})->purpose('Show the application identity');
