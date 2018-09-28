<?php

namespace App\Services;

use GuzzleHttp\Client;

class GitHubServiceProvider extends ServiceProvider
{

    public function getResult($searchTerm)
    {
        $client = new Client();
        $result = $client->request('GET', 'https://api.github.com/search/issues?q=' . $searchTerm);

        return $result->getBody();
    }

    public function getCount($result)
    {
        return json_decode($result)->total_count;
    }
}