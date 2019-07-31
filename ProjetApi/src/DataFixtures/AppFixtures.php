<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('moussa');
        $password = $this->encoder->encodePassword($user, '1234');
        $user->setPassword($password);
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setNom('thiam');
        $user->setPrenom('redakt');
        $user->setAdresse('thiaroye');
        $user->setTel(772086894);
        $user->setMatricule('nsdh123');
        $user->setStatus('actif');
        $user->setEmail('aktmere@gmail.com');

        $manager->persist($user);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
