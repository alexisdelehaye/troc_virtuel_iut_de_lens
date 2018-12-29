<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use App\Entity\User;
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
        // quelques "profils" (catégorie utilisateur)
        $profil = (new Profil())->setNomprofil("Etudiant");
        $manager->persist($profil);
        $profil2 = (new Profil())->setNomprofil("Enseignant");
        $manager->persist($profil2);


        $user = new User();
        $user->setNomuser("Doe")
            ->setPrenompersonne("John")
            ->setEmailuser("user@user.fr")
            ->setPseudo("JohnDoe62")
            ->setPassworduser($this->encoder->encodePassword($user, "secret"));
        $manager->persist($user);

        $user2 = new User();
        $user2->setNomuser("Smalling")
            ->setPrenompersonne("Chris")
            ->setEmailuser("admin@admin.fr")
            ->setPseudo("CS")
            ->setPassworduser($this->encoder->encodePassword($user2, "secret"));
        $manager->persist($user2);

        $manager->flush();
    }
}
