laravel-mandrill
================

Install it with

> composer require "hydrarulz/laravel-mandrill-interface:dev-master"

Add the service provider at the end of the `providers` array in file `config/app.php`:

> 'Hydrarulz\LaravelMandrillInterface\LaravelMandrillInterfaceServiceProvider',

The service provider will register an interface, but you should also register the alias at the end of the `aliases` array:
> 'LaravelMandrillInterface' => 'Hydrarulz\LaravelMandrillInterface\Facades\LaravelMandrillInterface',

Then the you should publish the config file with
`php artisan vendor:publish`
This creates your config file `/config/laravel-mandrill-interface.php` that looks like this:

    <?php

    return [
        'token' => env('MANDRILL_TOKEN')
        , 'pretend' => env('MAIL_PRETEND')
    ];

Add your Mandrill token to the `.env` file and set the pretend value `true` of `false`.

    # Mandrill setup
    MANDRILL_TOKEN=YOUR_TOKEN_HERE
    MAIL_PRETEND=false

After this you can start using it in your application

```php
$message = [
    'to' => [
        [
            'email' => 'example@server.com',
            'name' => 'Daniel Luca',
            'type' => 'to'
        ]
    ]
    , 'global_merge_vars' => [
        [
            'name' => 'VARIABLE_ID'
            , 'content' => '1234'
        ]
    ]
];

$mandrill_interface = LaravelMandrillInterface::getInstance();
$mandrill_interface->sendTemplate(
    'your_template'
    , []
    , $message
    , true
);
```

Or event the `send` method.
