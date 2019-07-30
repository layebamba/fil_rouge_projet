<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManager;
use App\Entity\Partenaire;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Compte;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte",methods={"GET"})
     * @IsGranted("ROLE_PARTENAIRE")
     */
    public function compte(Request $request,SerializerInterface $serializer,
    EntityManagerInterface $entityManager,ValidatorInterface $validator)
    {
        $values=json_decode($request->getContent());
        if(isset($values->partenaire_id))
        {
            $compte= new Compte();
            $part=$this->getDoctrine()->getRepository(Partenaire::class)->find($values->partenaire_id);
            $compte->setPartenaire($part);
            $compte->setMontant($values->montant);
            $errors= $validator->validate($compte);
            if(count($errors)){
                $errors= $serializer->serialize($errors,'json');
                return new Response($errors,500,['Content-Type'=>'Application/json']);
            }
            $entityManager->persist($compte);
            $entityManager->flush();
            $data=['status'=>201,'message'=>'compte alimenter'];
            return new JsonResponse($data,201);
        }
        $data=['status'=>500,'message'=>'erreurs'];
return new JsonResponse($data,500);
       
    }



}
