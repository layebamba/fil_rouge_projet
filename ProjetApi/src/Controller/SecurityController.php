<?php

namespace App\Controller;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;





/**
 * @Route("/api")
 */

class SecurityController extends AbstractController
{
   /**
    *@Route("/register",name="register",methods={"POST"})
    *@IsGranted("ROLE_ADMIN")
    */
    public function register(Request $request,UserPasswordEncoderInterface $userPasswordEncoder,EntityManagerInterface $entityManager,SerializerInterface $serializer,ValidatorInterface $validator)
    {
        $values=json_decode($request->getContent());
        if(isset($values->username,$values->password,$values->nom,$values->prenom,$values->adresse,
        $values->tel,$values->matricule,$values->status,$values->email))
        {

        $user=new User();
        $user->setUsername($values->username);
        $user->setPassword($userPasswordEncoder->encodePassword($user,$values->password));
        $user->setRoles($user->getRoles());
        $user->setNom($values->nom);
        $user->setPrenom($values->prenom);
        $user->setAdresse($values->adresse);
        $user->setTel($values->tel);
        $user->setMatricule($values->matricule);
        $user->setStatus($values->status);
        $user->setEmail($values->email);
        $part=$this->getDoctrine()->getRepository(Partenaire::class)->find($values->idpartenaire);
        $user->setIdPartenaire($$values->IdPartenaire);
        $errors=$validator->validate($user);
        if(count($errors)){
            $errors=$serializer->serialize($errors,'json');
            return new Response($errors,500,['Content-Type'=>'Application/json']);
            
        }



        $entityManager->persist($user);
        $entityManager->flush();

        $data=['status'=>201,'message'=>'l\'utilisateur a été crée'];

        return new JsonResponse($data,201);

        }
        $data=[
            'status'=>500,
            'messsage'=>'vous devez renseigner les cles username et password'
        ];
        return new JsonResponse($data,500);
    }

    /**
     * @Route("/login",name="login",methods={"GET"})
     */
    public function login(Request $request)
    {
        $user=$this->getUser();
        return $this->json(['username'=> $user->getUsername(),
        'roles'=>$user->getRoles()]);
    }
}


