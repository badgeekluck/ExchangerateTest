<?php


namespace App\Controller;


use App\Entity\ExchangeRate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ExchangeRateController extends AbstractController
{
    public function insertToDb($contests)
    {
        $exChange = new ExchangeRate();
        $em = $this->getDoctrine()->getManager();

        foreach ($contests as $key => $value) {

            $exChange->setValue($value[0]['amount']);
            $exChange->setCurrencyUnit($value[0]['symbol']);

            $em->persist($exChange);
            $em->flush();

            return new Response('Saved new product with id '.$exChange->getId());
        }
    }

}