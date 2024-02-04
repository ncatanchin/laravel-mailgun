<?php

namespace Bogardo\Mailgun\Contracts;

use Closure;

interface Mailgun
{

    /**
     * @param string|array $view
     * @param array        $data
     * @param \Closure     $callback
     *
     * @return \Bogardo\Mailgun\Http\Response
     */
    public function send(string $domain, $view, array $data, Closure $callback);

    /**
     * @param string   $message
     * @param \Closure $callback
     *
     * @return \Bogardo\Mailgun\Http\Response
     */
    public function raw($message, Closure $callback);

    /**
     * @param int|string|array $time
     * @param string|array     $view
     * @param array            $data
     * @param \Closure         $callback
     *
     * @return \Bogardo\Mailgun\Http\Response
     */
    public function later(string $domain, $time, $view, array $data, Closure $callback);
}
