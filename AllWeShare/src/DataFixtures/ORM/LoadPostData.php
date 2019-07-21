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
                'title' => 'Spotify account to share !',
                'description' => 'I have an account Spotify premium and i\'m looking for 3 people to join me on it !',
                'nblike' => 34,
                'author' => 5,
                'organization' => 3,
                'TypePost' => 'spotify',
            ],
            [
                'title' => 'Netflix',
                'description' => 'There is a place left in my account sharing, we are a friendly group',
                'nblike' => 5,
                'author' => 4,
                'organization' => 2,
                'TypePost' => 'netflix',
            ],
            [
                'title' => 'ADN',
                'description' => 'Interested to share ADN account with me ? :D',
                'nblike' => 12,
                'author' => 4,
                'organization' => 1,
                'TypePost' => 'adn',
            ],
            [
                'title' => 'Wakanim',
                'description' => 'Come looking all animes you want with me ! ',
                'nblike' => 21,
                'author' => 5,
                'organization' => 2,
                'TypePost' => 'wakanim',
            ],

            [
                'title' => 'Netflix',
                'description' => 'There is a place left in my account sharing, we are a friendly group',
                'nblike' => 5,
                'author' => 2,
                'organization' => 2,
                'TypePost' => 'netflix',
            ],
            [
                'title' => 'Deezer',
                'description' => 'Wanna listen music everywhere at minor cost ? join me',
                'nblike' => 12,
                'author' => 4,
                'organization' => 1,
                'TypePost' => 'deezer',
            ],
            [
                'title' => 'Netflix',
                'description' => 'Come looking all animes you want with me ! ',
                'nblike' => 21,
                'author' => 5,
                'organization' => 2,
                'TypePost' => 'netflix',
            ],
        ];
    }
}