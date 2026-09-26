<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return ['default'=>env('LOG_CHANNEL','stack'),'deprecations'=>['channel'=>env('LOG_DEPRECATIONS_CHANNEL','null'),'trace'=>false],'channels'=>['stack'=>['driver'=>'stack','channels'=>['single'],'ignore_exceptions'=>false],'single'=>['driver'=>'single','path'=>storage_path('logs/laravel.log'),'level'=>env('LOG_LEVEL','debug'),'replace_placeholders'=>true],'stderr'=>['driver'=>'monolog','level'=>env('LOG_LEVEL','debug'),'handler'=>StreamHandler::class,'with'=>['stream'=>'php://stderr'],'replace_placeholders'=>true],'syslog'=>['driver'=>'monolog','level'=>env('LOG_LEVEL','debug'),'handler'=>SyslogUdpHandler::class,'handler_with'=>['host'=>env('PAPERTRAIL_URL'),'port'=>env('PAPERTRAIL_PORT'),'connectionString'=>'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT')],'replace_placeholders'=>true],'null'=>['driver'=>'monolog','handler'=>NullHandler::class],'emergency'=>['path'=>storage_path('logs/laravel.log')]]];
