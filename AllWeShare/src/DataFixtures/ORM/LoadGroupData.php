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
                $setter = sprintf('set%s', ucfirst($key));
                if ('owner' === $key) {
                    $value = $this->getReference('USER_' . $data['owner']);
                }
                if ('user1' === $key) {
                    $value = $this->getReference('USER_' . $data['user1']);
                }
                if ('user2' === $key) {
                    $value = $this->getReference('USER_' . $data['user2']);
                }
                if ('user3' === $key) {
                    $value = $this->getReference('USER_' . $data['user3']);
                }
                $group->$setter($value);
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
                'name' => 'NetGroup',
                'username' => 'sylvain.coutrot@hotmail.fr',
                'password' => 'azertyuiop',
                'place' => 2,
                'owner' => 1,
                'user1' => 3,
            ],
            [
                'name' => 'WeshGrp',
                'username' => 'dumont.antoine27@gmail.com',
                'password' => 'azertyuiop',
                'place' => 1,
                'owner' => 2,
                'user1' => 1,
                'user2' => 3,
            ],
            [
                'name' => 'TqtGroup',
                'username' => 'jonathrakoto91400@gmail.com',
                'password' => 'azertyuiop',
                'place' => 3,
                'owner' => 3,
            ],
        ];
    }
}