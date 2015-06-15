<?php namespace App\Http\Controllers;

use Github\Client as Client;
use Github\ResultPager as Paginator;

use App\Github\RateLimit;
use App\Repository;

class SyncController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $token = \Auth::user()->token->token;
        $client = new Client();
        $client->authenticate($token, null, Client::AUTH_HTTP_TOKEN);
        $paginator = new Paginator($client);
        $client->setHeaders([
            'Accept' => sprintf('application/vnd.github.%s.star+json', $client->getOption('api_version'))
        ]);

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
        }

        \Auth::user()->repositories()->sync($repo_ids);

        $limit = new RateLimit($token);

        return $limit->getData()->getRemaining();
    }

}
