<?php

namespace App\Controller;
use App\Entity\Transaction;
use App\Entity\Partenaire;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Date;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/api")
 */
class TransactionController extends AbstractController
 {


    /**
     * @Route("/transaction", name="transaction")
     *  
     */
    public function trans(Request $request,SerializerInterface  $serializer ,
    ValidatorInterface $validator,SerializerInterface $Serializer, EntityManagerInterface $entityManager)
    {
     $values=json_decode($request->getContent());
     if(isset($values->partenaire_id,$values->somme,$values->datetransaction))
     {
         $transaction= new Transaction();
         $part=$this->getDoctrine()->getRepository(Partenaire::class)->find($values->partenaire_id);
         $transaction->setPartenaire($part);
         $transaction->setSomme($values->somme);
         $transaction->setDatetransaction(new\DateTime());
        $errors=$validator->validate($transaction);
        if(count($errors)){
            $errors=$Serializer->serialize($errors,'json');
            return new Response($errors,500,['Content-Type'=>'Application/json']);

        }
        $entityManager->persist($transaction);
        $entityManager->flush();
        $data=['status'=>201,'message'=>'transaction effectuée'];
        return new JsonResponse($data,201);
     }
     $data=['status'=>500,'message'=>'echouer'];
     return new JsonResponse($data,500);
    
    }
    /**
     * @Route("/listetrans",name="liste",methods={"GET"})
     */
    public function listetrans(TransactionRepository $transactionRepository,SerializerInterface $serializer)
    {
        $transact=$transactionRepository->findAll();
        $data=$serializer->serialize($transact,'json');
        return new Response($data,200,['Content-Type'=>'Application/json']);
    }
}
