<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static $articleTitle = [
      'Hello Dünya',
      'Hello World',
      'Merhaba Dünya',
      'Merhaba World',
    ];

    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png'
    ];

    private static $articleAuthors = [
        'Harun Baş',
        'Jack London',
        'Daniel Defoe',
        'Victur Hugo',
    ];
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {
            $article->setTitle($this->faker->randomElement(self::$articleTitle))
                ->setContent('
Object-oriented Programming, or OOP for short, is a programming paradigm which provides a means of structuring programs so that properties and behaviors are bundled into individual objects.

For instance, an [object](https://baconipsum.com/) could represent a person with a name property, age, address, etc., with behaviors like walking, talking, breathing, and running. Or an email with properties like recipient list, subject, body, etc., and behaviors like adding attachments and sending.

Put another way, object-oriented programming is an approach for modeling concrete, real-world things like cars as well as relations between things like companies and employees, students and teachers, etc. OOP models real-world entities as software objects, which have some data associated with them and can perform certain functions.

Another common programming paradigm is procedural programming which structures a program like a recipe in that it provides a set of steps, in the form of functions and code blocks, which flow sequentially in order to complete a task.

The key takeaway is that objects are at the center of the object-oriented programming paradigm, not only representing the data, as in procedural programming, but in the overall structure of the program as well.
;');

            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImage($this->faker->randomElement(self::$articleImages));

            /**
             * @var Tag[] $tags
             */
            $tags = $this->getRandomReferences(Tag::class, $this->faker->numberBetween(0,5));
            foreach ($tags as $tag) {
                 $article->addTag($tag);
                 //$article->removeTag($tag);
            }
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TagFixture::class
        ];
    }

}
