<?php

namespace App\DataFixtures;

use App\Entity\Carrier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarrierFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'title' => 'TransCompany',
                'deliveryRules' => [
                    [
                        'type' => 'lte',
                        'value' => 10,
                        'formula' => 10,
                    ],
                    [
                        'type' => 'gt',
                        'value' => 10,
                        'formula' => 100,
                    ],
                ],
            ],
            [
                'title' => 'PackGroup',
                'deliveryRules' => [
                    [
                        'type' => 'gt',
                        'value' => 0,
                        'formula' => 'weight * 10',
                    ],
                ],
            ],
        ];

        foreach ($data as $item) {
            $carrier = new Carrier();
            $carrier->setTitle($item['title']);
            $carrier->setDeliveryRules($item['deliveryRules']);
            $manager->persist($carrier);
        }

        $manager->flush();
    }
}
