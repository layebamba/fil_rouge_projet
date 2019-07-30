<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Partenaire;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PartenaireRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire", name="partenaire",methods={"POST"})
     */
    public function new(Request $request,EntityManagerInterface $entityManager,SerializerInterface $serializer)
    {
        $partenaire=$serializer->deserialize($request->getContent(),Partenaire::class,'json');
        $entityManager->persist($partenaire);
        $entityManager->flush();
        $data=['status'=>201,'message'=>'ajout reussi'];
        return new JsonResponse($data,201);
    }

    /**
     * @Route("/listpart",name="listparte",methods={"GET"})
     */
public function listpart(PartenaireRepository $partenaireRepository,SerializerInterface $serializer )
{
    $parte= $partenaireRepository->findAll();
    $data=$serializer->serialize($parte,'json');
    return new Response($data,200,['Content-Type'=>'Application/json']);
}


}
