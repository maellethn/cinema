<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlloController extends AbstractController
{
    /**
     * @Route("/allo", name="home")
     */
    public function index(FilmRepository $rfilm)
    {
        $film = $rfilm->findAll();
        return $this->render('allo/index.html.twig', [
            'controller_name' => 'AlloController',
        ]);
    }
}
