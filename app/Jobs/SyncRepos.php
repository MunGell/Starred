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
     * Create a new job instance.
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

        $client = new Client();
        $client->authenticate($this->user->token->token, null, Client::AUTH_HTTP_TOKEN);
        $paginator = new Paginator($client);
        $client->setHeaders([
            'Accept' => sprintf('application/vnd.github.%s.star+json', $client->getOption('api_version'))
        ]);

        if ($client->api('rate_limit')->getRateLimits()['rate']['remaining'] < 20) {
            return;
        }

        $repos = $paginator->fetchAll($client->api('current_user')->starring(), 'all', []);
        $repo_ids = [];

        // @todo: change to direct database connection for performance reasons
        foreach ($repos as $repo) {
            $repo_ids[$repo['repo']['id']] = [
                'starred_at' => strtotime($repo['starred_at'])
            ];

            Repository::updateOrCreate([
                'id' => $repo['repo']['id']
            ], [
                'name' => $repo['repo']['name'],
                'full_name' => $repo['repo']['full_name'],
                'url' => $repo['repo']['html_url'],
                'description' => $repo['repo']['description']
            ]);

            if (!is_null($repo['repo']['language'])) {
                $tag = Tag::findOrCreate($repo['repo']['language']);
                if (!$tag->repositories()->getRelatedIds()->contains($repo['repo']['id'])) {
                    $tag->repositories()->attach($repo['repo']['id']);
                }
            }
        }

        $this->user->repositories()->sync($repo_ids);
        $this->user->detachJob($this->job->getJobId());
    }
}
