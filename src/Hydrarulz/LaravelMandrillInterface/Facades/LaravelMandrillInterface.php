<?php namespace Hydrarulz\LaravelMandrillInterface\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelMandrillInterface extends Facade {
    protected static function getFacadeAccessor() { return 'mandrill-interface'; }
}
