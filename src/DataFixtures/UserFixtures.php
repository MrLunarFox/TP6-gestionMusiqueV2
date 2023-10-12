<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPassword;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPassword = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        $genres = ["male", "female"];

        for ($i = 0; $i < 20; $i++) {
            $sexe = mt_rand(0,1);
            if ($sexe == 0) {
                $type = "men";
            } else {
                $type = "women";
            }
            $user = new User();
            $user->setNom($faker->lastName())
                    ->setPrenom($faker->firstName($genres[$sexe]))
                    ->setEmail($faker->email())
                    ->setSexe($sexe)
                    ->setIsVerified(true)
                    ->setAvatar("https://randomuser.me/api/portraits/". $type ."/". $i .".jpg")
                    ->setPassword(
                        $this->userPassword->hashPassword(
                            $user,
                            "0123456789"
                        )
                    )
                    ;
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setNom("admin")
                    ->setPrenom("Josua")
                    ->setEmail("admin@gmail.com")
                    ->setSexe(0)
                    ->setIsVerified(true)
                    ->setRoles(['ROLE_ADMIN'])
                    ->setAvatar("https://randomuser.me/api/portraits/men/9.jpg")
                    ->setPassword(
                        $this->userPassword->hashPassword(
                            $admin,
                            "admin1234"
                        )
                    )
                    ;
            $manager->persist($admin);

        $manager->flush();
    }
}
