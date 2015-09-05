<?php namespace App\Github;

use Github\Client as Client;

class RateLimit
{
    protected $data = null;

    protected $client;

    public function __construct($token)
    {
        $this->client = new Client();
        $this->client->authenticate($token, null, Client::AUTH_HTTP_TOKEN);
    }

    public function getData() {
        $this->data = json_decode($this->client->getHttpClient()->get('/rate_limit')->getBody());
        return $this;
    }

    public function getRemaining() {
        return $this->data->rate->remaining;
    }

    public function getLimit() {
        return $this->data->rate->limit;
    }

    public function isReached($estimation = 20) {
        return ($this->data->rate->remaining < $estimation);
    }

}
