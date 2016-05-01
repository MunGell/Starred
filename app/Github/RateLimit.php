<?php

namespace Starred\Github;

use Github\Client as Client;

/**
 * Class RateLimit
 * @package Starred\Github
 * @todo: use library for this now
 */
class RateLimit
{
    /**
     * @var object|null
     */
    protected $data = null;

    /**
     * @var \Github\Client
     */
    protected $client;

    /**
     * RateLimit constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->client = new Client();
        $this->client->authenticate($token, null, Client::AUTH_HTTP_TOKEN);
    }

    /**
     * @return $this
     */
    public function getData() {
        $this->data = json_decode($this->client->getHttpClient()->get('/rate_limit')->getBody());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemaining() {
        return $this->data->rate->remaining;
    }

    /**
     * @return mixed
     */
    public function getLimit() {
        return $this->data->rate->limit;
    }

    /**
     * @param int $estimation
     *
     * @return bool
     */
    public function isReached($estimation = 20) {
        return ($this->data->rate->remaining < $estimation);
    }
}
