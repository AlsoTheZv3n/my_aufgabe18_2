<?php


namespace App\Service;


use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleProvider {


    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function searchGoogle(string $keyword, int $limit): array {

        $url = 'https://www.google.com/search';

        $response = $this->client->request('GET', $url, [
            'query' => [
                'q' => $keyword,
                'num' => $limit,
            ],
        ]);

        // Parse and process the HTML response
        $content = $response->getContent();

        $crawler = new Crawler($content);

        $results = [];

        // Extract information from the search results
        $crawler->filter('.tF2Cxc')->each(
            function ($node) use (&$results) {

            $title = $node->filter('h3')->text();

            $url = $node->filter('a')->attr('href');

            $description = $node->filter('.IsZvec')->text();

            $results[] = [
                'title' => $title,
                'url' => $url,
                'description' => $description,
            ];
        });

        return $results;

    }
}
