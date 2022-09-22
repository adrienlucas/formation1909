<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) { }

    public function load(ObjectManager $manager): void
    {
        $adrien = new User();
        $adrien->setUsername('adrien');
        $adrien->setRoles(['ROLE_ADMIN']);
        $adrien->setPassword(
            $this->passwordHasher->hashPassword($adrien, 'adrien')
        );

        /** @var Movie $movie */
        $movie = $this->getReference('movie_matrix');
        $movie->setCreatedBy($adrien);

        $manager->persist($adrien);

        $john = new User();
        $john->setUsername('john');
        $john->setPassword(
            $this->passwordHasher->hashPassword($john, 'john')
        );

        $manager->persist($john);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [MovieFixtures::class];
    }
}
