<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     * @param EntityManager $entityManager
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function new (EntityManagerInterface $entityManager)
    {
        $article = new Article();
        $article->setTitle('Hello Wolrd')
            ->setSlug('test-hello-harun-'.rand(100,999))
            ->setContent('
Object-oriented Programming, or OOP for short, is a programming paradigm which provides a means of structuring programs so that properties and behaviors are bundled into individual objects.

For instance, an [object](https://baconipsum.com/) could represent a person with a name property, age, address, etc., with behaviors like walking, talking, breathing, and running. Or an email with properties like recipient list, subject, body, etc., and behaviors like adding attachments and sending.

Put another way, object-oriented programming is an approach for modeling concrete, real-world things like cars as well as relations between things like companies and employees, students and teachers, etc. OOP models real-world entities as software objects, which have some data associated with them and can perform certain functions.

Another common programming paradigm is procedural programming which structures a program like a recipe in that it provides a set of steps, in the form of functions and code blocks, which flow sequentially in order to complete a task.

The key takeaway is that objects are at the center of the object-oriented programming paradigm, not only representing the data, as in procedural programming, but in the overall structure of the program as well.
;');

        if (rand(1,10) > 2) {
            $article->setPublishedAt(new \DateTime(sprintf('-%d days' ,rand(1,100))));
        }

        $article->setAuthor('Jack London')
            ->setHeartCount(rand(5, 100))
            ->setImage('asteroid.jpeg');

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response(sprintf('New article id: #%d slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}