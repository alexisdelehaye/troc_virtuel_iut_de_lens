<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Objet;
use App\Entity\Profil;
use App\Entity\Transaction;
use App\Entity\Typetransaction;
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


        //données permettant de tester l'application

        //utilisateur 1
        $user = new User();
        $user->setNomuser("Doe")
            ->setPrenompersonne("John")
            ->setEmailuser("user@user.fr")
            ->setPseudo("JohnDoe62")
            ->setPassworduser($this->encoder->encodePassword($user, "secret"));
        $manager->persist($user);

        //utilisateur 2
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


        //categories pour les objets
        $categorie1 = new Categorie();
        $categorie1->setNomcategorie('High tech');
        $categorie1->setDescriptioncategorie('Produit high tech (smatphone, pc,etc');

        $manager->persist($categorie1);
        $manager->flush();

        //objet 1 de l'utilisateur 1
        $object1 = new Objet();
        $object1->setNomobjet('Iphone 4s 16go');
        $object1->setIdproprietaire($user);
        $object1->setDescriptionobjet("Iphone 4s 16go quasi neuf chargeur inclus");
        $object1->setDisponible(true);
        $object1->setIdcategorie($categorie1);
        $object1->setIdtransaction(null);

        $manager->persist($object1);
        $manager->flush();


        //objet 2 de l'utilisateur 1
        $object2 = new Objet();
        $object2->setNomobjet('souris microsoft sans fil');
        $object2->setDisponible(true);
        $object2->setDescriptionobjet('Microsoft Modern Mobile Mouse, Cette souris sans fil légère et portable fonctionne sur pratiquement toutes les surfaces grâce à la BlueTrack Technology.');
        $object2->setIdproprietaire($user);
        $object2->setIdcategorie($categorie1);
        $object2->setIdtransaction(null);

        $manager->persist($object2);
        $manager->flush();

        //type de transaction disponible :

        $typeTransaction1 = new Typetransaction();
        $typeTransaction1->setNomtransaction('don');
        $typeTransaction1->setDatedebuttransaction(null);
        $typeTransaction1->setDatefintransaction(null);


        $manager->persist($typeTransaction1);
        $manager->flush();

    }


}
