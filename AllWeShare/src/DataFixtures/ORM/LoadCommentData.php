<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCommentData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCommentDatas() as $data) {
            $comment = new Comment();

            foreach ($data as $key => $value) {
                $setter = sprintf('set%s', ucfirst($key));
                if ('author' === $key) {
                    $value = $this->getReference('USER_' . $data['author']);
                }
                if ('post' === $key) {
                    $value = $this->getReference('POST_' . $data['post']);
                }

                $comment->$setter($value);
            }
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadUserData::class,
            LoadPostData::class,
        ];
    }

    private function getCommentDatas(): array
    {
        return [
            [
                'content' => 'I want to share with youuuu',
                'author' => 3,
                'post' => 2,
            ],
            [
                'content' => 'yo mec',
                'author' => 2,
                'post' => 1,
            ],
        ];
    }
}