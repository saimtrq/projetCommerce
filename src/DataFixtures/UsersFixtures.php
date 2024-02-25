<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
    {





    }
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@test.ch');
        $admin->setLastName('Saim');
        $admin->setFirstName('Tariq');
        $admin->setAddress('Rue de la tambourine 20');
        $admin->setZipcode('1227');
        $admin->setCity('Genève');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('ch_CH');

        for ($i = 1; $i <= 5; $i++) {
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastName($faker->lastName);
            $user->setFirstName($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode($faker->postcode);
            $user->setCity($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            $manager->persist($user);
        }




        $manager->flush();
    }
}
