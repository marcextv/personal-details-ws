<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Person;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

	// mock data
	for ($i = 0; $i < 10; $i++) {
		$person = new Person();
		$person->setName(sprintf('foo%d', $i));
		$person->setLastName(sprintf('last%d', $i));
		$person->setEmail(sprintf('foo%d@test.com', $i));
		$person->setCi(sprintf('000000000%d', $i));
		$manager->persist($person);
	}    
	$manager->flush();
    }
}
