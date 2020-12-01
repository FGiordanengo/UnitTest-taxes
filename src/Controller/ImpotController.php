<?php

namespace App\Controller;

use App\Service\CalculateurImpot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImpotController extends AbstractController
{
    /**
     * @Route("/", name="impot")
     */
    public function index(Request $request, CalculateurImpot $calculateurImpot): Response
    {
        $fb = $this->createFormBuilder();
        $form = $fb
            ->add('revenu', IntegerType::class)
            ->add('nbPart', IntegerType::class)
            ->add('save', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        $result = [];
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $revenu = $data['revenu'];
            $nbPart = $data['nbPart'];
            $result = $calculateurImpot->calcul($revenu, $nbPart);
        }

        return $this->render('impot/index.html.twig', [
            'form' => $form->createView(),
            'impot' => $result,
        ]);
    }
}
