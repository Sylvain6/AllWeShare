<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\Entity\Request;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRequestData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getRequestDatas() as $data) {
            $request = new Request();

            foreach ($data as $key => $value) {
                $setter = sprintf('set%s', ucfirst($key));
                if ('applicant' === $key) {
                    $value = $this->getReference('USER_' . $data['applicant']);
                }
                if ('post' === $key) {
                    $value = $this->getReference('POST_' . $data['post']);
                }
                $request->$setter($value);
            }
            $manager->persist($request);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadPostData::class,
        ];
    }

    private function getRequestDatas(): array
    {
        return [
            [
                'status' => 'PENDING',
                'post' => 1,
                'applicant' => 4,
            ],
            [
                'status' => 'ACCEPTED',
                'post' => 1,
                'applicant' => 2,
            ],
            [
                'status' => 'REJECTED',
                'post' => 1,
                'applicant' => 1,
            ],
        ];
    }
}