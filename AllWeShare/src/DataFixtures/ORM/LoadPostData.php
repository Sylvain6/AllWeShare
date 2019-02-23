<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPostData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $i =  1;
        foreach ($this->getPostDatas() as $data) {
            $post = new Post();

            foreach ($data as $key => $value) {
                $setter = sprintf('set%s', ucfirst($key));
                if ('author' === $key) {
                    $value = $this->getReference('USER_' . $data['author']);
                }
                if ('organization' === $key) {
                    $value = $this->getReference('GROUP_' . $data['organization']);
                }

                $post->$setter($value);
            }
            $manager->persist($post);
            $this->setReference('POST_' . $i, $post);
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadUserData::class,
            LoadGroupData::class,
        ];
    }

    private function getPostDatas(): array
    {
        return [
            [
                'title' => 'I want to share my account',
                'descritpion' => 'I have a streaming platform account that i want to share',
                'nblike' => 34,
                'author' => 3,
                'organization' => 1,
            ],
            [
                'title' => '1 pace left',
                'descritpion' => 'There is a place left in my account sharing, we are a friendly group',
                'nblike' => 5,
                'author' => 2,
                'organization' => 2,
            ],
            [
                'title' => 'WESH ALORS',
                'descritpion' => 'VASY VENEZ',
                'nblike' => 0,
                'author' => 1,
                'organization' => 3,
            ],
        ];
    }
}