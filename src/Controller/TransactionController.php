<?php

namespace App\Controller;

use DateTime;
use App\Entity\Transaction;
use App\Services\UserService;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionController extends AbstractController
{


    private $transactionRepo;

    public function __construct(
        TransactionRepository $transactionRepo){
        $this->transactionRepo= $transactionRepo;
    }

    /**
     * @Route("/api/transaction/depots", name="depot", methods={"POST"})
     */
    public function depot(Request $request, SerializerInterface $serialize,ClientRepository $clientRepo , 
    EntityManagerInterface $em, TransactionRepository $transactionRepo, UserService $userService): Response
    {
        $user_depot= $this->getUser();
        
        $compte= $user_depot->getAgence()->getCompte();
        $data= \json_decode($request->getContent(), true);

        if($data['type'] === 'depot'){
            if($compte->getMontant() < $data['montant'] ){
                return $this->json([
                    'message'=>'votre compte est inssuffisant'
                ],400);
            }
            
            
            $transaction= $serialize->denormalize($data, "App\Entity\Transaction");
             //dd($transaction);
            $transaction->initialise($this->getUser());
            $transaction->setCode($userService->CreerMatricule($data["clientDepot"]["nomComplet"]));
            $compte->setMontant($compte->getMontant() - $transaction->getMontant());
            $transaction->setType("depot");

            $em->persist($transaction);
            $userService->sendSMS($transaction->getMontant(), $transaction->getClientDepot()->getNomComplet(), $transaction->getCode());
            $em->flush();
    
            return $this->json([
                'message'=> 'depot reussi',
                'data'=> $transaction
            ]);

        }elseif($data['type'] == 'annulation'){
            if($transaction = $transactionRepo->findOneBy(['code'=>$data['code']])){
                if($transaction->getDateRetrait() == null){
                    if($transaction->getDateAnnulation() == null){
                        $transaction->setDateAnnulation(new DateTime('now')); 
                        $compte->setMontant($compte->getMontant() + $transaction->getMontant());
                        $transaction->setType("annulé");
                        $em->flush();
                        return $this->json([
                            'message'=>'Transaction annuler avec succée'
                        ],200);
                    }else{
                        return $this->json([
                            'message'=>'transaction déja annuler'
                        ],400);
                    }
                }else{
                    return $this->json([
                        'message'=>'Argent déja retirer'
                    ],400);
                }
            }else{
                return $this->json([
                    'message'=>'ce code de transaction n\'existe pas !'
                ],400);
            }

        }elseif($data['type'] == 'retrait'){
            if($transaction = $transactionRepo->findOneBy(['code'=>$data['code']])){
                //dd($transaction);
                if($transaction->getDateRetrait() == null){
                    
                    if($transaction->getDateAnnulation() == null){
                        if($compte->getMontant() > $transaction->getMontant()){
                            $transaction->setDateRetrait(new DateTime('now'));
                            $transaction->setUserRetrait($user_depot);
                            $transaction->setType("retrait");
                            //$transaction->setfraisRetrait();

                            $compte->setMontant( $compte->getMontant()+ $transaction->getFraisRetrait());
                            $transaction->getClientRetrait()->setCNI($data['cni']);
                            $em->flush();
                            return $this->json([
                                'message'=>'retirer avec success'
                            ],200);
                        }else{
                            return $this->json([
                                'message'=>'le montant du compte est inferieur'
                            ],400);
                        }
                        
                    }else{
                        return $this->json([
                            'message'=>'la transaction a ete annule'
                        ],400);
                    }
                }else{
                    return $this->json([
                        'message'=>'Argent déja retiré.'
                    ],400);
                }
            }
            else{
                return $this->json([
                    'message'=>'ce code de transaction n\'existe pas'
                ],400);
            }
            
        }elseif($data['type'] == 'rechercher'){
            if($transaction = $transactionRepo->findOneBy(['code'=>$data['code']])){
                $result = array();
                $result['montant'] =$transaction->getMontant();
                $result['dateDepot'] =$transaction->getDateDepot()->format('d-m-Y');
                $result['telephoneClientDepot']= $transaction->getClientDepot()->getTelephone();
                $result['nomClientDepot']= $transaction->getClientDepot()->getNomComplet();
                $result['cniClientDepot']= $transaction->getClientDepot()->getTelephone();
                $result['telephoneClientRetrait']= $transaction->getClientRetrait()->getTelephone();
                $result['nomClientRetrait']= $transaction->getClientRetrait()->getNomComplet();
                return $this->json([
                    'data'=>$result
                ],200);
            }else{
                return $this->json([
                    'message'=>'ce code de transaction n\'existe pas'
                ],400);
            }

        }
    }

    /**
     * @Route("/api/transaction/commissions" , name="commission", methods={"GET"})
     */

     public function commission(){

        $transaction= $this->transactionRepo->findAll();
        //dd($transaction);
         $userCurent= $this->getUserDepot();
         dd($userCurent);
        //  $transaction= $userCurent->getTransactions();
        //  dd($transaction);

        //  return $this->json($transaction, 200);


     }


    /**
     * @Route("/api/transaction/mesTransactions" , name="mesTransactions", methods={"GET"})
     */

    public function MesTransaction(){

        $transaction= $this->transactionRepo->findAll();
        //dd($transaction);
         $userCurent= $this->getUserDepot();
         dd($userCurent);


          return $this->json($transaction, 200);


     }
}
