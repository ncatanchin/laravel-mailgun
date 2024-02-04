<?php

namespace Bogardo\Mailgun;

use Bogardo\Mailgun\Contracts\Mailgun as MailgunContract;
use Bogardo\Mailgun\Mail\Mailer;
use Closure;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\View\Factory;
use Mailgun\Mailgun;

class Service implements MailgunContract
{

    /**
     * @var \Mailgun\Mailgun
     */
    protected $mailgun;

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var \Bogardo\Mailgun\Mail\Mailer
     */
    protected $mailer;

    /**
     * Service constructor.
     *
     * @param \Mailgun\Mailgun                        $mailgun
     * @param \Illuminate\View\Factory                $view
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Mailgun $mailgun, Factory $view, Config $config)
    {
        $this->mailgun = $mailgun;
        $this->view = $view;
        $this->config = $config;
        $this->mailer = new Mailer($this->mailgun, $view, $this->config);
    }

    /**
     * @param string    $domiain
     * @param string    $view
     * @param array     $data
     * @param \Closure  $callback
     *
     * @return \Mailgun\Model\Message\SendResponse
     */
    public function send(string $domain, $view, array $data, Closure $callback)
    {
        return $this->mailer->send($domain, $view, $data, $callback);
    }

    /**
     * @param string   $message
     * @param \Closure $callback
     *
     * @return \Mailgun\Model\Message\SendResponse
     */
    public function raw($message, Closure $callback)
    {
        return $this->mailer->send(['raw' => $message], [], $callback);
    }

    /**
     * @param string    $domain
     * @param int|array $time
     * @param string    $view
     * @param array     $data
     * @param \Closure  $callback
     *
     * @return \Mailgun\Model\Message\SendResponse
     */
    public function later(string $domain, $time, $view, array $data, Closure $callback)
    {
        return $this->mailer->later($domain, $time, $view, $data, $callback);
    }

    /**
     * @return \Mailgun\Mailgun
     */
    public function api()
    {
        return $this->mailgun;
    }


    /**
     * @return \Mailgun\Lists\OptInHandler
     */
    public function optInHandler()
    {
        return $this->mailgun->OptInHandler();
    }

    /**
     * Get the Validator service.
     *
     * @return \Bogardo\Mailgun\Validation\Validator
     */
    public function validator()
    {
        return new Validation\Validator(app('mailgun.public'));
    }
}
