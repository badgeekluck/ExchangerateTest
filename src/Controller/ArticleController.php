<?php


namespace App\Controller;

use App\Service\MarkdownHelper;
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
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, MarkdownHelper $markdownHelper)
    {
        $comments = [
            'This is not good.',
            'This is good.',
            'This is bad.',
        ];

        $articleContent = <<<EOF
Object-oriented Programming, or OOP for short, is a programming paradigm which provides a means of structuring programs so that properties and behaviors are bundled into individual objects.

For instance, an [object](https://baconipsum.com/) could represent a person with a name property, age, address, etc., with behaviors like walking, talking, breathing, and running. Or an email with properties like recipient list, subject, body, etc., and behaviors like adding attachments and sending.

Put another way, object-oriented programming is an approach for modeling concrete, real-world things like cars as well as relations between things like companies and employees, students and teachers, etc. OOP models real-world entities as software objects, which have some data associated with them and can perform certain functions.

Another common programming paradigm is procedural programming which structures a program like a recipe in that it provides a set of steps, in the form of functions and code blocks, which flow sequentially in order to complete a task.

The key takeaway is that objects are at the center of the object-oriented programming paradigm, not only representing the data, as in procedural programming, but in the overall structure of the program as well.
EOF;

        $articleContent = $markdownHelper->parse($articleContent);

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'articleContent' => $articleContent,
            'slug' => $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted.');

        return new JsonResponse(['heart' => rand(5,100)]);
    }

}