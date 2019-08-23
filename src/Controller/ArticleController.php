<?php


namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use function PHPSTORM_META\type;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/getforeginexchangerate")
     */
    public function getForeginExchangeRate()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0');
        $contents = $response->toArray();

        foreach ($contents as $key => $value) {
            $test = $value[0]['symbol'];
            dd(gettype($test));
        }
        exit();

        return new Response($content);
    }

    /**
     * @Route("/getturkishexchangerate")
     */
    public function getTurkishExchangeRate()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3');
        $content = $response->getContent();
        return new Response($content);
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article)
    {

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $article->incrementHeartCount();
        $entityManager->flush();

        $logger->info('Article is being hearted.');

        return new JsonResponse(['heart' => $article->getHeartCount()]);
    }

}