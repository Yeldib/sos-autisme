<?php

namespace App\DataFixtures;

use App\Entity\ProUser;
use App\Entity\Role;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new ProUser();
        $adminUser->setFirstName('Ethan')
                  ->setLastName('EL DIB')
                  ->setEmail('e.ethan@gmail.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  ->setPhoneNumber('0666323275')
                  ->setJobCategory('Developpeur Web')
                  ->setAddress('4 rue Dantesque')
                  ->setPostalCode('27140')
                  ->setCity('Gisors')
                  ->setDepartment('27')
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);

        // Gestion des utilisateurs PRO
        $users = [];
        $genres = ['male', 'female'];

        for ($i=1; $i <= 15; $i++) { 
            $proUser = new ProUser();

            $genre = $faker->randomElement($genres);

            $profilePicture = 'https://randomuser.me/api/portraits/';
            $profilePictureId = $faker->numberBetween(1, 99) . '.jpg';

            $profilePicture .= ($genre == 'male' ? 'men/' : 'women/') . $profilePictureId;

            $hash = $this->encoder->encodePassword($proUser, 'password');

            $proUser->setLastName($faker->lastName())
                    ->setFirstName($faker->firstName($genre))
                    ->setEmail($faker->email())
                    ->setProfilePicture($profilePicture)
                    ->setHash($hash)
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setJobCategory('Orthophoniste')
                    ->setAddress($faker->streetAddress())
                    ->setPostalCode($faker->postcode())
                    ->setCity($faker->city())
                    ->setDepartment($faker->departmentNumber())
                    ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>');

            $manager->persist($proUser);
            $users[] = $proUser;
        }
    
        $manager->flush();
    }
}
