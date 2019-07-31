<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManager;

/**
 * @Route("/api")
 */

class SecurityController extends AbstractController
{
    /**
     *@Route("/register",name="register",methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder,
        EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator) {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password, $values->nom, $values->prenom, $values->adresse,
            $values->tel, $values->matricule, $values->status, $values->email, $values->partenaire_id)) {

            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($userPasswordEncoder->encodePassword($user, $values->password));
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setAdresse($values->adresse);
            $user->setTel($values->tel);
            $user->setMatricule($values->matricule);
            $user->setStatus($values->status);
            $user->setEmail($values->email);
            $part = $this->getDoctrine()->getRepository(Partenaire::class)->find($values->partenaire_id);
            $user->setPartenaire($part);
            $errors = $validator->validate($user);
            if (count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, ['Content-Type' => 'Application/json']);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $data = ['status' => 201, 'message' => 'l\'utilisateur a été crée'];

            return new JsonResponse($data, 201);

        }
        $data = [
            'status' => 500,
            'messsage' => 'vous devez renseigner les cles username et password',
        ];
        return new JsonResponse($data, 500);
    }
    /**
     * @Route("/listuser",name="listuser",methods={"GET"})
     */
    public function listuser(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $users = $userRepository->findAll();
        $data = $serializer->serialize($users, 'json');
        return new Response($data, 200, ['Content-Type' => 'Application/json']);
    }
    /**
     * @Route("/update/{id}",name="updateuser",methods={"PUT"})
     */

    public function update(Request $request, SerializerInterface $serializer, EntityManagerInterface
         $entityManager, User $user, ValidatorInterface $validator) {
        $userUpdate = $entityManager->getRepository(User::class)->find($user->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value) {
            if ($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set' . $name;
                $userUpdate->$setter($value);

            }
        }
        $errors = $validator->validate($userUpdate);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, ['Content-Type' => 'Application/json']);

        }
        $entityManager->flush();
        $data = ['status' => 200, 'message' => 'mise a jour effectué'];
        return new JsonResponse($data);
    }
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }


    public function userBloquer(Request $request, UtilisateurRepository $userRepo,EntityManagerInterface $entityManager):reponse{
    
        $values = json_decode($request->getContent());
        $user=$userRepo->findOneByUsername($values->username);
        echo $user->getStatut();
        if ($user->getStatut()=="bloquer"){
            if($user->getProfil()=="admin"){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            elseif($user->getProfil()=="admin"){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            elseif($user->getProfil()=="admin"){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            $user->setStatut("debloquer");
        }
        else{
            $user->getProfil()=="admin"){
            $user->setRoles(["ROLE_ADMIN"]);
        }

        $entityManager->setStatut("bloquer");
        $data = [
            'statut' => 200,
            'message' => 'utilisateur bloque'
        ];
        return new JsonResponse($data);
    }
}
