<?php namespace Hydrarulz\LaravelMandrillInterface;

use Illuminate\Support\Facades\Config;
use Mandrill;

use Log;

class LaravelMandrillInterface extends Mandrill {


    /**
     * Mandrill secret token
     * @var string
     */
    protected $token;

    /**
     * Pretend to send the emails instead of just logging the structure.
     * @var bool
     */
    protected $pretend;

    private static $_instance;

    /**
     * @param array $token
     * @param array $options
     */
    public function __construct($token, $options = array())
    {
        $this->setToken($token);

        if (isset($options['pretend']))
        {
            $this->setPretend($options['pretend']);
        }

        self::$_instance = parent::__construct($this->token);
    }

    /**
     * @param bool  $token
     * @param array $options
     * @return LaravelMixpanel
     */
    public static function getInstance($token = false)
    {
        if (!$token)
        {
            $token = Config::get('laravel-mandrill-interface.token');
        }

        /**
         * Init the library and use the generated cookie by the Javascript to identify the user.
         */
        if (!isset(self::$_instance))
        {
            self::$_instance = new LaravelMandrillInterface(
                $token
                , [
                    'pretend' => Config::get('laravel-mandrill-interface.pretend')
                ]
            );
        }

        return self::$_instance;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


    /**
     * @return mixed
     */
    public function getPretend()
    {
        return $this->pretend;
    }

    /**
     * @param bool $pretend
     */
    public function setPretend($pretend)
    {
        $this->pretend = $pretend;
    }


    /**
     * Wrapper function thaxt sends emails based on templates
     * @param string $templateName    The name of the template being used
     * @param array $templateContent [description]
     * @param array $message         The structured array that contains all of the message data (compatible to Mandrill native library)
     * @param bool  $async           Sending the email asynchronously or not
     */
    public function sendTemplate($templateName, $templateContent, $message, $async = true)
    {
        if (!$this->getPretend())
        {
            $result = $this->getInstance()->messages->sendTemplate($templateName, $templateContent, $message, $async);
            Log::info(var_export($result, true));
        }
        else
        {
            $result = true;
            Log::info(var_export($message, true));
        }

        return $result;
    }

    /**
     * Wrapper function that sends plain emails
     * @param  array $message The structured array that contains all of the message data (compatible to Mandrill native library)
     * @return array          Mandrill structured array with the response
     */
    public function send($message)
    {
        if (!$this->getPretend())
        {
            $result = $this->getInstance()->messages->send($message);
            Log::info(var_export($result, true));
        }
        else
        {
            $result = true;
            Log::info(var_export($message, true));
        }

        return $result;
    }
}
