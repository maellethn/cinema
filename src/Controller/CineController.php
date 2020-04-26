<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;

use App\Repository\FilmRepository;
use App\Repository\ActeurRepository;
use App\Repository\CategorieRepository;
use App\Repository\RealisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CineController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration", methods={"GET","POST"})
     */
    public function registration(Request $request, ObjectManager $mana)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $mana->persist($user);
            $mana->flush();
            $this->addFlash('success', 'User Created! Knowledge is power!');
            return $this->redirectToRoute('cine');
        }

        return $this->render('security/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/acteur/{id}", name="acteur_show", methods={"GET"})
     */
    public function acteurShow(ActeurRepository $racteur, string $id)
    {
        $acteur = $racteur->find($id);

        return $this->render('cine/acteurshow.html.twig', [
            'controller_name' => 'CineController',
            'acteur' => $acteur
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categorie_show", methods={"GET"})
     */
    public function categorieShow(CategorieRepository $rcategorie, string $id)
    {
        $categorie = $rcategorie->find($id);

        return $this->render('cine/categorieshow.html.twig', [
            'controller_name' => 'CineController',
            'categorie' => $categorie
        ]);
    }
    
    /**
     * @Route("/realisateur/{id}", name="realisateur_show", methods={"GET"})
     */
    public function realisateurShow(RealisateurRepository $rrealisateur, string $id)
    {
        $realisateur = $rrealisateur->find($id);

        return $this->render('cine/realisateurshow.html.twig', [
            'controller_name' => 'CineController',
            'realisateur' => $realisateur
        ]);
    }
    
    /**
     * @Route("/cine/{id}", name="cine_show", methods={"GET"})
     */
    public function cineShow(FilmRepository $rfilm, string $id)
    {
        $film = $rfilm->find($id);
        //calcul de la moyenne du film 
        $moyenne=0;
        $sommeNote=0;
        $nbNote=0;
        foreach ($film->getCommentaire() as $commentaire) {
            $sommeNote+=$commentaire->getNote();
            $nbNote++;
        }
        if ($nbNote!=0) {
            $moyenne=$sommeNote/$nbNote;
        }

        return $this->render('cine/filmshow.html.twig', [
            'controller_name' => 'CineController',
            'film' => $film,
                        'note'=>$moyenne
        ]);
    }


    /**
     * @Route("/categorie", name="categorie", methods={"GET"})
     */
    public function categorie(CategorieRepository $rcategorie)
    {
        $categorie = $rcategorie->findAll();

        return $this->render('cine/categorie.html.twig', [
            'controller_name' => 'CineController',
            'categorie' => $categorie
        ]);
    }

    /**
     * @Route("/realisateur", name="realisateur", methods={"GET"})
     */
    public function realisateur(RealisateurRepository $rrealisateur)
    {
        $realisateur = $rrealisateur->findAll();
        
        return $this->render('cine/realisateur.html.twig', [
            'controller_name' => 'CineController',
            'realisateur' => $realisateur
        ]);
    }

    /**
     * @Route("/acteur", name="acteur", methods={"GET"})
     */
    public function acteur(ActeurRepository $racteur)
    {
        $acteur = $racteur->findAll();
        
        return $this->render('cine/acteur.html.twig', [
            'controller_name' => 'CineController',
            'acteur' => $acteur
        ]);
    }

    /**
     * @Route("/", name="home")
     * @Route("/cine", name="cine")
     */
    public function cine(FilmRepository $rfilm)
    {
        $films = $rfilm->findAll();
        //les films a l'affiche
        $affiche=[];
        foreach ($films as $film) {
            if ($film->getEtat() == 1) {
                $affiche[]=$film;
            }
        }
        
        return $this->render('cine/index.html.twig', [
            'controller_name' => 'CineController',
            'Aaffiche' => $affiche,

        ]);
    }
}
