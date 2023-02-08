<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/get/city/{term}', name: 'app_api')]
    public function index(string $term, Request $request, EntityManagerInterface $entityManager): Response
    {
        $conn = $entityManager->getConnection();
        $sql = 'SELECT ville_departement, ville_nom_reel, ville_code_postal FROM spec_villes_france WHERE ville_nom_reel LIKE :term';
        $result = $conn->prepare($sql)->executeQuery(['term' => '%'.$term.'%'])->fetchAllAssociative();

        return new JsonResponse($result);
    }
}
