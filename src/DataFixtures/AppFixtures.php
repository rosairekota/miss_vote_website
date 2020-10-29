<?php

namespace App\DataFixtures;

use App\Entity\Cote;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Votant;
use App\Entity\Comment;
use App\Entity\Candidat;
use App\Entity\Competition;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var mixed
     *
     * @var [UserPasswordEncoderInterface]
     */
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker=\Faker\Factory::create('fr_FR');
        $votant=new Votant();
          for ($i = 0; $i < 8; $i++) {
           

            // 1) ON INSERE LES Candidat et les votants

           
            $votant->setNom($faker->name)
                     ->setPrenom($faker->firstName)
                     ->setSexe("M")
                     ->setAdresse($faker->address)
                     ->setTelephone($faker->phoneNumber)
                     ->setEmail($faker->email)
                     ->setCategory('votant')
                     ->setPhotoName($faker->imageUrl())
                     ->setMotdepass($faker->password());
            $manager->persist($votant);

      
   

        
            
            // 2) ON INSERE Les Competitions

         $comp=new Competition();
        $candidat=new Candidat();

          $comp->setTitre($faker->title)
               ->setPrix($faker->numberBetween(0,1700))
               ->setDateCompetition($faker->dateTime)
               ->setLieu($faker->country);
        $manager->persist($comp);


        $candidat->setNom($faker->name)
                     ->setPostnom($faker->lastName)
                     ->setPrenom($faker->firstName)
                     ->setSexe("M")
                     ->setDateNaissance($faker->dateTime)
                     ->setDescription($faker->sentence)
                     ->setAdresse($faker->address)
                     ->setTelephone($faker->phoneNumber)
                     ->setEmail($faker->email)
                     ->setOrigine($faker->city)
                     ->setPhotoName($faker->imageUrl())
                     ->setMotdepasse($faker->password())
                     ->setCompetition($comp);
            $manager->persist($candidat);

            // 3) Partie Blog :

             // 2) ON INSERE LES Post et Users
             $post=new Post();
             $user=new User();
                
                    $hash=$this->encoder->encodePassword($user,'12345678');
                     $user->setEmail($faker->email)
                           ->setUsername($faker->userName)
                          ->setPassword($hash)
                          ->setRoles(['ROLE_ADMIN','ROLE_USER']);
                    $manager->persist($user);

                $post->setTitle($faker->sentence)
                     ->setImageName($faker->imageUrl())
                     ->setContent($faker->words(100,true))
                     ->setPosted(true)
                     ->setCategory(substr($faker->title,5,0))
                     ->setUser($user)
                     ->setCandidat($candidat);

                     -
                $manager->persist($post);


        // ON INSERE LES COTES,LES COMMENTAIRES ET THEMES
                $cmt=new Comment();
                $cotes=new Cote();
                $theme=new Theme();
                for ($j=0; $j <10 ; $j++) { 
                    $cmt->setPost($post)
                        ->setVotant($votant)
                        ->setCandidat($candidat)
                        ->setComment($faker->paragraph);
                    $manager->persist($cmt);

                    $cotes->setCandidat($candidat)
                          ->setVotant($votant)
                          ->setCoteVotant($faker->numberBetween(0,20))
                          ->setCoteJury($faker->numberBetween(0,20));
                    $manager->persist($cotes);

                    $theme->setTitre($faker->title)
                          ->setDescription($faker->sentence)
                          ->setExigence($faker->sentence)
                          ->setCompetition($comp);
                     $manager->persist($theme);
                }
         
        
          }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
