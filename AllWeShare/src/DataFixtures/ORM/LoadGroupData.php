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
                'name' => 'Groupe Netflix 1',
                'username' => 'huberttohu@hotmail.fr',
                'password' => 'azertyuiop',
                'place' => 1,
                'owner' => 4,
                'user' => [3, 2],
            ],
            [
                'name' => 'Groupe ADN',
                'username' => 'hubert_T',
                'password' => 'azertyuiop',
                'place' => 2,
                'owner' => 4,
                'user' => [1] ,
            ],
            [
                'name' => 'Groupe Spotify',
                'username' => 'adupuis@gmail.com',
                'password' => 'azertyuiop',
                'place' => 2,
                'owner' => 5,
            ],

            [
                'name' => 'Wakanim Andrea',
                'username' => 'adupuis@gmail.com',
                'password' => 'azertyuiop',
                'place' => 1,
                'owner' => 5,
            ],
        ];
    }
}