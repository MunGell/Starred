<?php namespace App\Http\Controllers;

use Github\Client as Client;
use Github\ResultPager as Paginator;

use App\Github\RateLimit;
use App\Repository;
use App\Tag;

class SyncController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $token = \Auth::user()->token->token;

        $limit = new RateLimit($token);

        if($limit->getData()->isReached()) {
            return redirect()->action('RepositoryController@index');
        }

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

            if (!is_null($repo['repo']['language'])) {
                $tag = Tag::findOrCreate($repo['repo']['language']);
                if (!$tag->repositories()->getRelatedIds()->contains($repo['repo']['id'])) {
                    $tag->repositories()->attach($repo['repo']['id']);
                }
            }
        }

        \Auth::user()->repositories()->sync($repo_ids);

        return redirect()->action('RepositoryController@index');
    }

}
