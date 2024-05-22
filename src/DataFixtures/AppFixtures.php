<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Domain;
use App\Entity\Shortcode;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasherInterface)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User(
            'chris@vendiadvertising.com',
            [User::ROLE_USER, User::ROLE_ADMIN]
        );
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, 'test'));
        $manager->persist($user);

        $client = new Client('Vendi Advertising');
        $client->addUser($user);
        $manager->persist($client);

        $domain = new Domain('t.vendi.run');
        $client->addDomain($domain);
        $manager->persist($domain);

        $url = new Shortcode('https://example.com', 'gerp', $domain);
        $manager->persist($url);


//        $domain->setClient($client);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
