<?php

namespace Starred\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use Github\Client as Client;
use Github\ResultPager as Paginator;

use Starred\Repository;
use Starred\User;
use Starred\Tag;

/**
 * Class SyncRepos
 * @package Starred\Jobs
 */
class SyncRepos extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var \Starred\User
     */
    protected $user;

    /**
     * SyncRepos constructor.
     *
     * @param \Starred\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // @todo: temporary fix for the acceptance tests
        if (!isset($this->user->token->token)) {
            return;
        }

        $client = $this->getClient();

        if ($this->isLimitReached($client)) {
            return;
        }

        $repositories = $this->getAllRepositories($client);
        $repository_ids = [];

        foreach ($repositories as $repository) {
            $repository_ids[$repository['repo']['id']] = [
                'starred_at' => strtotime($repository['starred_at'])
            ];

            $this->addRepository($repository);
            $this->addLanguageTag($repository);
        }

        $this->user->repositories()->sync($repository_ids);
        $this->user->detachJob($this->job->getJobId());
    }

    /**
     * @return \Github\Client
     */
    protected function getClient()
    {
        $client = new Client();
        $client->authenticate($this->user->token->token, null, Client::AUTH_HTTP_TOKEN);
        $client->setHeaders([
            'Accept' => sprintf('application/vnd.github.%s.star+json', $client->getOption('api_version'))
        ]);

        return $client;
    }

    /**
     * @param $client
     *
     * @return array
     */
    protected function getAllRepositories($client)
    {
        $paginator = new Paginator($client);

        return $paginator->fetchAll($client->api('current_user')->starring(), 'all', []);
    }

    /**
     * @param $client
     *
     * @return bool
     */
    protected function isLimitReached($client)
    {
        return $client->api('rate_limit')->getRateLimits()['rate']['remaining'] < 20;
    }

    /**
     * @param array $repository
     */
    protected function addRepository($repository)
    {
        Repository::updateOrCreate([
            'id' => $repository['repo']['id']
        ], [
            'name' => $repository['repo']['name'],
            'full_name' => $repository['repo']['full_name'],
            'url' => $repository['repo']['html_url'],
            'description' => $repository['repo']['description']
        ]);
    }

    /**
     * @param array $repository
     */
    protected function addLanguageTag($repository)
    {
        if (!is_null($repository['repo']['language'])) {
            $tag = Tag::findOrCreate($repository['repo']['language']);
            if (!$tag->repositories()->getRelatedIds()->contains($repository['repo']['id'])) {
                $tag->repositories()->attach($repository['repo']['id']);
            }
        }
    }
}
