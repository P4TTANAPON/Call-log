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
		52 => 'December 26 - January 1',
	],

    'week_of_year_2017' =>[
		1 => 'January 2 - January 8',
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
];
