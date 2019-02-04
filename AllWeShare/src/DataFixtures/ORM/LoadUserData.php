<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadUserData extends AbstractFixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $i =  1;
        foreach ($this->getUserDatas() as $data) {
            $user = new User();

            foreach ($data as $key => $value) {
                $setter = sprintf('set%s', ucfirst($key));
                if ('password' === $key) {
                    $value = $this->encoder->encodePassword($user, $value);
                }

                $user->$setter($value);
            }
            $manager->persist($user);
            $this->setReference('USER_' . $i, $user);
            $i++;
        }

        $manager->flush();
    }


    private function getUserDatas(): array
    {
        return [
            [
                'firstName' => 'Sylvain',
                'lastName' => 'Coutrot',
                'email' => 'sylvain.coutrot@hotmail.fr',
                'address' => '12 rue georges duhamel',
                'city' => 'paris',
                'password' => 'azertyuiop',
                'roles' => 'ROLE_ADMIN',
            ],
            [
                'firstName' => 'Antoine',
                'lastName' => 'Dumont',
                'email' => 'dumont.antoine27@gmail.com',
                'address' => '17 passage barrault',
                'city' => 'paris',
                'password' => 'azertyuiop',
                'roles' => 'ROLE_ADMIN',
            ],
            [
                'firstName' => 'Jonathan',
                'lastName' => 'Rakotonirina',
                'email' => 'jonathrakoto91400@gmail.com',
                'address' => '18 rue paloindorsay',
                'city' => 'orsay',
                'password' => 'azertyuiop',
                'roles' => 'ROLE_ADMIN',
            ],
            [
                'firstName' => 'Hubert',
                'lastName' => 'Tohula',
                'email' => 'huberttohu@gmail.com',
                'address' => '7 rue bis ter complique',
                'city' => 'marseille',
                'password' => 'azertyuiop',
                'roles' => 'ROLE_USER',
            ],
        ];
    }
}