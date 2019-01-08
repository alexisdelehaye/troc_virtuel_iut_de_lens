<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Objet;
use App\Entity\Profil;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

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
            ->setRoles(['ROLE_ADMIN'])
            ->setPassworduser($this->encoder->encodePassword($user2, "secret"));
        $manager->persist($user2);

        $catlivres = new Categorie();
        $catlivres->setNomcategorie("Livres")
            ->setDescriptioncategorie("Livre en tout genres");
        $manager->persist($catlivres);

        $catdvd = new Categorie();
        $catdvd->setNomcategorie("DVD");
        $manager->persist($catdvd);

        $arr_cat = [$catlivres, $catdvd];
        $arr_user = [$user, $user2];

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 15; $i++) {
            $objet = new Objet();
            $objet->setNomobjet($faker->sentence(3))
                ->setDescriptionobjet($faker->paragraph())
                ->setDisponible($faker->randomElement([true,false]))
                ->setIdcategorie($faker->randomElement($arr_cat))
                ->setIdproprietaire($faker->randomElement($arr_user));
            $manager->persist($objet);
        }

        $manager->flush();
    }
}
