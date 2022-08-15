<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => 'http://localhost',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Bangkok',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('APP_LOG', 'single'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

		Maatwebsite\Excel\ExcelServiceProvider::class,
		Khill\Lavacharts\Laravel\LavachartsServiceProvider::class,
		
		hisorange\BrowserDetect\Provider\BrowserDetectService::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'       => Illuminate\Support\Facades\App::class,
        'Artisan'   => Illuminate\Support\Facades\Artisan::class,
        'Auth'      => Illuminate\Support\Facades\Auth::class,
        'Blade'     => Illuminate\Support\Facades\Blade::class,
        'Cache'     => Illuminate\Support\Facades\Cache::class,
        'Config'    => Illuminate\Support\Facades\Config::class,
        'Cookie'    => Illuminate\Support\Facades\Cookie::class,
        'Crypt'     => Illuminate\Support\Facades\Crypt::class,
        'DB'        => Illuminate\Support\Facades\DB::class,
        'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
        'Event'     => Illuminate\Support\Facades\Event::class,
        'File'      => Illuminate\Support\Facades\File::class,
        'Gate'      => Illuminate\Support\Facades\Gate::class,
        'Hash'      => Illuminate\Support\Facades\Hash::class,
        'Lang'      => Illuminate\Support\Facades\Lang::class,
        'Log'       => Illuminate\Support\Facades\Log::class,
        'Mail'      => Illuminate\Support\Facades\Mail::class,
        'Password'  => Illuminate\Support\Facades\Password::class,
        'Queue'     => Illuminate\Support\Facades\Queue::class,
        'Redirect'  => Illuminate\Support\Facades\Redirect::class,
        'Redis'     => Illuminate\Support\Facades\Redis::class,
        'Request'   => Illuminate\Support\Facades\Request::class,
        'Response'  => Illuminate\Support\Facades\Response::class,
        'Route'     => Illuminate\Support\Facades\Route::class,
        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Session'   => Illuminate\Support\Facades\Session::class,
        'Storage'   => Illuminate\Support\Facades\Storage::class,
        'URL'       => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View'      => Illuminate\Support\Facades\View::class,
		
		'Excel' => Maatwebsite\Excel\Facades\Excel::class,
		
		'BrowserDetect' => hisorange\BrowserDetect\Facade\Parser::class,
    ],

	'month_of_year' => [
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December',
	],

    /*
    |
    | Start monday
    |
    */

	'week_of_year_2016' =>[
		1 => 'January 4 - January 10',
		2 => 'January 11 - January 17',
		3 => 'January 18 - January 24',
		4 => 'January 25 - January 31',
		5 => 'February 1 - February 7',
		6 => 'February 8 - February 14',
		7 => 'February 15 - February 21',
		8 => 'February 22 - February 28',
		9 => 'February 29 - March 6',
		10 => 'March 7 - March 13',
		11 => 'March 14 - March 20',
		12 => 'March 21 - March 27',
		13 => 'March 28 - April 3',
		14 => 'April 4 - April 10',
		15 => 'April 11 - April 17',
		16 => 'April 18 - April 24',
		17 => 'April 25 - May 1',
		18 => 'May 2 - May 8',
		19 => 'May 9 - May 15',
		20 => 'May 16 - May 22',
		21 => 'May 23 - May 29',
		22 => 'May 30 - June 5',
		23 => 'June 6 - June 12',
		24 => 'June 13 - June 19',
		25 => 'June 20 - June 26',
		26 => 'June 27 - July 3',
		27 => 'July 4 - July 10',
		28 => 'July 11 - July 17',
		29 => 'July 18 - July 24',
		30 => 'July 25 - July 31',
		31 => 'August 1 - August 7',
		32 => 'August 8 - August 14',
		33 => 'August 15 - August 21',
		34 => 'August 22 - August 28',
		35 => 'August 29 - September 4',
		36 => 'September 5 - September 11',
		37 => 'September 12 - September 18',
		38 => 'September 19 - September 25',
		39 => 'September 26 - October 2',
		40 => 'October 3 - October 9',
		41 => 'October 10 - October 16',
		42 => 'October 17 - October 23',
		43 => 'October 24 - October 30',
		44 => 'October 31 - November 6',
		45 => 'November 7 - November 13',
		46 => 'November 14 - November 20',
		47 => 'November 21 - November 27',
		48 => 'November 28 - December 4',
		49 => 'December 5 - December 11',
		50 => 'December 12 - December 18',
		51 => 'December 19 - December 25',
		52 => 'December 26 - December 31',
	],

    'week_of_year_2017' =>[
		1 => 'January 1 - January 8',
		2 => 'January 9 - January 15',
		3 => 'January 16 - January 22',
		4 => 'January 23 - January 29',
		5 => 'January 30 - February 5',
		6 => 'February 6 - February 12',
		7 => 'February 13 - February 19',
		8 => 'February 20 - February 26',
		9 => 'February 27 - March 5',
		10 => 'March 6 - March 12',
		11 => 'March 13 - March 19',
		12 => 'March 20 - March 26',
		13 => 'March 27 - April 2',
		14 => 'April 3 - April 9',
		15 => 'April 10 - April 16',
		16 => 'April 17 - April 23',
		17 => 'April 24 - April 30',
		18 => 'May 1 - May 7',
		19 => 'May 8 - May 14',
		20 => 'May 15 - May 21',
		21 => 'May 22 - May 28',
		22 => 'May 29 - June 4',
		23 => 'June 5 - June 11',
		24 => 'June 12 - June 18',
		25 => 'June 19 - June 25',
		26 => 'June 26 - July 2',
		27 => 'July 3 - July 9',
		28 => 'July 10 - July 16',
		29 => 'July 17 - July 23',
		30 => 'July 24 - July 30',
		31 => 'July 31 - August 6',
		32 => 'August 7 - August 13',
		33 => 'August 14 - August 20',
		34 => 'August 21 - August 27',
		35 => 'August 28 - September 3',
		36 => 'September 4 - September 10',
		37 => 'September 11 - September 17',
		38 => 'September 18 - September 24',
		39 => 'September 25 - October 1',
		40 => 'October 2 - October 8',
		41 => 'October 9 - October 15',
		42 => 'October 16 - October 22',
		43 => 'October 23 - October 29',
		44 => 'October 30 - November 5',
		45 => 'November 6 - November 12',
		46 => 'November 13 - November 19',
		47 => 'November 20 - November 26',
		48 => 'November 27 - December 3',
		49 => 'December 4 - December 10',
		50 => 'December 11 - December 17',
		51 => 'December 18 - December 24',
		52 => 'December 25 - January 31',
    ],
    
    'week_of_year_2019' =>[
		1 => 'January 1 - January 5',
		2 => 'January 6 - January 12',
		3 => 'January 13 - January 19',
		4 => 'January 20 - January 26',
		5 => 'January 27 - February 2',
		6 => 'February 3 - February 9',
		7 => 'February 10 - February 16',
		8 => 'February 17 - February 23',
		9 => 'February 24 - March 2',
		10 => 'March 3 - March 9',
		11 => 'March 10 - March 16',
		12 => 'March 17 - March 23',
		13 => 'March 24 - March 30',
		14 => 'March 31 - April 6',
		15 => 'April 7 - April 13',
		16 => 'April 14 - April 20',
		17 => 'April 21 - April 27',
		18 => 'April 28 - May 4',
		19 => 'May 5 - May 11',
		20 => 'May 12 - May 18',
		21 => 'May 19 - May 25',
		22 => 'May 26 - June 1',
		23 => 'June 2 - June 8',
		24 => 'June 9 - June 15',
		25 => 'June 16 - June 22',
		26 => 'June 23 - June 29',
		27 => 'June 30 - July 6',
		28 => 'July 7 - July 13',
		29 => 'July 14 - July 20',
		30 => 'July 21 - July 27',
		31 => 'July 28 - August 3',
		32 => 'August 4 - August 10',
		33 => 'August 11 - August 17',
		34 => 'August 18 - August 24',
		35 => 'August 25 - August 31',
		36 => 'September 1 - September 7',
		37 => 'September 8 - September 14',
		38 => 'September 15 - September 21',
		39 => 'September 22 - September 28',
		40 => 'September 29 - October 5',
		41 => 'October 6 - October 12',
		42 => 'October 13 - October 19',
		43 => 'October 20 - October 26',
		44 => 'October 27 - November 2',
		45 => 'November 3 - November 9',
		46 => 'November 10 - November 16',
		47 => 'November 17 - November 23',
		48 => 'November 24 - November 30',
		49 => 'December 1 - December 7',
		50 => 'December 8 - December 14',
		51 => 'December 15 - December 21',
		52 => 'December 29 - January 4',
	],

	'week_of_year_2020' =>[
		1 => 'January 1 - January 5',
		2 => 'January 6 - January 12',
		3 => 'January 13 - January 19',
		4 => 'January 20 - January 26',
		5 => 'January 27 - February 2',
		6 => 'February 3 - February 9',
		7 => 'February 10 - February 16',
		8 => 'February 17 - February 23',
		9 => 'February 24 - March 2',
		10 => 'March 3 - March 9',
		11 => 'March 10 - March 16',
		12 => 'March 17 - March 23',
		13 => 'March 24 - March 30',
		14 => 'March 31 - April 6',
		15 => 'April 7 - April 13',
		16 => 'April 14 - April 20',
		17 => 'April 21 - April 27',
		18 => 'April 28 - May 4',
		19 => 'May 5 - May 11',
		20 => 'May 12 - May 18',
		21 => 'May 19 - May 25',
		22 => 'May 26 - June 1',
		23 => 'June 2 - June 8',
		24 => 'June 9 - June 15',
		25 => 'June 16 - June 22',
		26 => 'June 23 - June 29',
		27 => 'June 30 - July 6',
		28 => 'July 7 - July 13',
		29 => 'July 14 - July 20',
		30 => 'July 21 - July 27',
		31 => 'July 28 - August 3',
		32 => 'August 4 - August 10',
		33 => 'August 11 - August 17',
		34 => 'August 18 - August 24',
		35 => 'August 25 - August 31',
		36 => 'September 1 - September 7',
		37 => 'September 8 - September 14',
		38 => 'September 15 - September 21',
		39 => 'September 22 - September 28',
		40 => 'September 29 - October 5',
		41 => 'October 6 - October 12',
		42 => 'October 13 - October 19',
		43 => 'October 20 - October 26',
		44 => 'October 27 - November 2',
		45 => 'November 3 - November 9',
		46 => 'November 10 - November 16',
		47 => 'November 17 - November 23',
		48 => 'November 24 - November 30',
		49 => 'December 1 - December 7',
		50 => 'December 8 - December 14',
		51 => 'December 15 - December 21',
		52 => 'December 29 - January 4',
	],

	'week_of_year_2021' =>[
		1 => 'January 4 - January 10',
		2 => 'January 11 - January 17',
		3 => 'January 18 - January 24',
		4 => 'January 25 - January 31',
		5 => 'February 1 - February 7',
		6 => 'February 8 - February 14',
		7 => 'February 15 - February 21',
		8 => 'February 22 - February 28',
		9 => 'March 1 - March 7',
		10 => 'March 8 - March 14',
		11 => 'March 15 - March 21',
		12 => 'March 22 - March 28',
		13 => 'March 29 - April 4',
		14 => 'April 5 - April 11',
		15 => 'April 12 - April 18',
		16 => 'April 19 - April 25',
		17 => 'April 26 - May 2',
		18 => 'May 3 - May 9',
		19 => 'May 10 - May 16',
		20 => 'May 17 - May 23',
		21 => 'May 24 - May 30',
		22 => 'May 31 - June 6',
		23 => 'June 7 - June 13',
		24 => 'June 14 - June 20',
		25 => 'June 21 - June 27',
		26 => 'June 28 - July 4',
		27 => 'July 5 - July 11',
		28 => 'July 12 - July 18',
		29 => 'July 19 - July 25',
		30 => 'July 26 - August 1',
		31 => 'August 2 - August 8',
		32 => 'August 9 - August 15',
		33 => 'August 16 - August 22',
		34 => 'August 23 - August 29',
		35 => 'August 30 - September 5',
		36 => 'September 6 - September 12',
		37 => 'September 13 - September 19',
		38 => 'September 20 - September 26',
		39 => 'September 27 - October 3',
		40 => 'October 4 - October 10',
		41 => 'October 11 - October 17',
		42 => 'October 18 - October 24',
		43 => 'October 25 - October 31',
		44 => 'November 1 - November 7',
		45 => 'November 8 - November 14',
		46 => 'November 15 - November 21',
		47 => 'November 22 - November 28',
		48 => 'November 29 - December 5',
		49 => 'December 6 - December 12',
		50 => 'December 13 - December 19',
		51 => 'December 20 - December 26',
		52 => 'December 27 - January 2',
	],

  'week_of_year_2022' =>[
		1 => 'January 3 - January 9',
		2 => 'January 10 - January 16',
		3 => 'January 17 - January 23',
		4 => 'January 24 - January 30',
		5 => 'January 31 - February 6',
		6 => 'February 7 - February 13',
		7 => 'February 14 - February 20',
		8 => 'February 21 - February 27',
		9 => 'February 28 - March 6',
		10 => 'March 7 - March 13',
		11 => 'March 14 - March 20',
		12 => 'March 21 - March 27',
		13 => 'March 28 - April 3',
		14 => 'April 4 - April 10',
		15 => 'April 11 - April 17',//break
		16 => 'April 18 - April 24',
		17 => 'April 25 - May 1',
		18 => 'May 2 - May 8',
		19 => 'May 9 - May 15',
		20 => 'May 16 - May 22',
		21 => 'May 23 - May 29',
		22 => 'May 30 - June 5',
		23 => 'June 6 - June 12',
		24 => 'June 13 - June 19',
		25 => 'June 20 - June 26',
		26 => 'June 27 - July 3',
		27 => 'July 4 - July 10',
		28 => 'July 11 - July 17',
		29 => 'July 18 - July 24',
		30 => 'July 25 - July 31',
		31 => 'August 1 - August 7',
		32 => 'August 8 - August 14',
		33 => 'August 15 - August 21',
		34 => 'August 22 - August 28',
		35 => 'August 29 - September 4',
		36 => 'September 5 - September 11',
		37 => 'September 12 - September 18',
		38 => 'September 19 - September 25',
		39 => 'September 26 - October 2',
		40 => 'October 3 - October 9',
		41 => 'October 10 - October 16',
		42 => 'October 17 - October 23',
		43 => 'October 24 - October 30',
		44 => 'October 31 - November 6',
		45 => 'November 7 - November 13',
		46 => 'November 14 - November 20',
		47 => 'November 21 - November 27',
		48 => 'November 28 - December 4',
		49 => 'December 5 - December 11',
		50 => 'December 12 - December 18',
		51 => 'December 19 - December 25',
		52 => 'December 26 - January 1',
	],
];
