<?php


namespace App\Controller;


use App\Service\GoogleProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WikipediaProvider;

#[Route('/search/{keyword}/{limit}', name: 'index')]
class Index extends AbstractController {

    public function __construct(
        private readonly WikipediaProvider $wikipediaProvider,
        private readonly GoogleProvider $googleProvider,
    ){
    }

    public function __invoke(string $keyword, int $limit): Response {


        $resultsWikipedia = $this->wikipediaProvider->searchWikipedia($keyword, $limit);

        $resultsGoogle = $this->googleProvider->searchGoogle($keyword, $limit);


        return $this->render('index.html.twig', [
            'resultsWikipedia' => $resultsWikipedia,
            'resultsGoogle' => $resultsGoogle,
        ]);
    }



}
