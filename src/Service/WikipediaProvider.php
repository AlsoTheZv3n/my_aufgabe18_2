<?php


namespace App\Service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class WikipediaProvider {

    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function searchWikipedia(string $keyword, int $limit): array {

        $url = 'https://en.wikipedia.org/w/api.php';

        $response = $this->client->request(
            'GET', $url, [
            'query' => [
                'action' => 'query',
                'origin' => '*',
                'format' => 'json',
                'generator' => 'search',
                'gsrnamespace' => 0,
                'gsrlimit' => $limit,
                'gsrsearch' => $keyword,
            ],
        ]);


        $wikipediaSearchRequest = $response->toArray();


        return $wikipediaSearchRequest;

    }
}
