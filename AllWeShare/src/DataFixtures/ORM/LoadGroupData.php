<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGroupData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $i =  1;
        foreach ($this->getGroupDatas() as $data) {
            $group = new Group();

            foreach ($data as $key => $value) {
                if ('user' === $key) {
                    $users = $data['user'];
                    foreach ($users as $user){
                        $theUser = $this->getReference('USER_' . $user);
                        $group->addUser($theUser);
                    }
                } else {
                    $setter = sprintf('set%s', ucfirst($key));
                    if ('owner' === $key) {
                        $value = $this->getReference('USER_' . $data['owner']);
                    }
                    $group->$setter($value);
                }
            }
            $manager->persist($group);
            $this->setReference('GROUP_' . $i, $group);
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadUserData::class,
        ];
    }

    private function getGroupDatas(): array
    {
        return [
            [
                'name' => 'Groupe Spotify 1',
                'username' => 'andreaSpotify@gmail.com',
                'password' => 'azertyuiop',
                'place' => 1,
                'owner' => 4,
                'user' => [3, 2],
            ],
            [
                'name' => 'Groupe Netflix',
                'username' => 'hubert_T',
                'password' => 'azertyuiop',
                'place' => 2,
                'owner' => 4,
                'user' => [1, 5] ,
            ],
            [
                'name' => 'Groupe ADN',
                'username' => 'hubert_t@gmail.com',
                'password' => 'azertyuiop',
                'place' => 2,
                'owner' => 4,
            ],

            [
                'name' => 'Wakanim Andrea',
                'username' => 'adupuis@gmail.com',
                'password' => 'azertyuiop',
                'place' => 1,
                'owner' => 5,
                'user' => [1,2] ,
            ],
            [
                'name' => 'Groupe Netflix Antoine',
                'username' => 'AntoineD',
                'password' => 'azertyuiop',
                'place' => 2,
                'owner' => 2,
                'user' => [1,5] ,
            ],
            [
                'name' => 'Groupe Deezer Hubert',
                'username' => 'adupuis@gmail.com',
                'password' => 'azertyuiop',
                'place' => 2,
                'owner' => 4,
            ],

            [
                'name' => 'Netfix Andrea',
                'username' => 'adupuis@gmail.com',
                'password' => 'azertyuiop',
                'place' => 1,
                'owner' => 5,
                'user' => [3,2] ,
            ],
        ];
    }
}