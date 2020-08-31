<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\ProUser;
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

        $adminUser = new User();
        $adminUser->setFirstName('Ethan')
                  ->setLastName('EL DIB')
                  ->setEmail('e.ethan@gmail.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);

        // Gestion des utilisateurs PRO
        $ProUsers = [];
        $genres = ['male', 'female'];
        $jobs = ['Orthophoniste', 'Pédopsychiatre', 'Éducateur(trice) spécialisé(e)', 'Psychomotricien(ne)', 'Psychologue'];

        for ($i=1; $i <= 525; $i++) { 
            $proUser = new ProUser();
            $user = new User();

            $genre = $faker->randomElement($genres);

            $profilePicture = 'https://randomuser.me/api/portraits/';
            $profilePictureId = $faker->numberBetween(1, 99) . '.jpg';

            $profilePicture .= ($genre == 'male' ? 'men/' : 'women/') . $profilePictureId;

            $hash = $this->encoder->encodePassword($proUser, 'password');

            $proUser->setLastName($faker->lastName())
                    ->setFirstName($faker->firstName($genre))
                    ->setEmail($faker->email())
                    ->setPicture($profilePicture)
                    ->setHash($hash)
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setJobCategory($faker->randomElement($jobs))
                    ->setAddress($faker->streetAddress())
                    ->setPostalCode($faker->postcode())
                    ->setCity($faker->city())
                    ->setDepartment($faker->departmentNumber())
                    ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                    ->setCompanySiret('123 456 789 12345');

            $manager->persist($proUser);
            $ProUsers[] = $proUser;           
        }

        // Gestion des utilisateurs
        $users = [];
        $genres = ['male', 'female'];
        $jobs = ['Orthophoniste', 'Pédopsychiatre', 'Éducateur(trice) spécialisé(e)', 'Psychomotricien(ne)', 'Psychologue'];

        for ($i=1; $i <= 55; $i++) { 
            $user = new User();

            $genre = $faker->randomElement($genres);

            $profilePicture = 'https://randomuser.me/api/portraits/';
            $profilePictureId = $faker->numberBetween(1, 99) . '.jpg';

            $profilePicture .= ($genre == 'male' ? 'men/' : 'women/') . $profilePictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setPseudo($faker->userName())
                 ->setLastName($faker->lastName())
                 ->setFirstName($faker->firstName($genre))
                 ->setEmail($faker->email())
                 ->setPicture($profilePicture)
                 ->setHash($hash)
                 ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ;   

            $manager->persist($user);
            $users[] = $user;
            
            // Gestion des commentaires
            if (mt_rand(0, 1)) {
                $comment = new Comment();
                $comment->setContent($faker->paragraph())
                        ->setRating(mt_rand(1, 5))
                        ->setAuthor($user)
                        ->setProUser($proUser);
    
                $manager->persist($comment);
            }
            
        }
    
        $manager->flush();
    }
}
