<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Realisateur;
use App\Repository\RealisateurRepository;
use App\Entity\Acteur;
use App\Repository\ActeurRepository;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Entity\BandeAnnonce;
use App\Repository\BandeAnnonceRepository;
use App\Entity\Photo;
use App\Repository\PhotoRepository;
use App\Entity\Sceance;
use App\Repository\SceanceRepository;
use App\Entity\Salle;
use App\Repository\SalleRepository;
use App\Entity\Film;
use App\Repository\FilmRepository;
use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    /**
     * @Route("/liste_realisateur", name="liste_realisateur")
     */
    public function listeRealisateur(RealisateurRepository $realisateurRepo)
    {
    	$realisateurs=$realisateurRepo->findAll();
        return $this->render('site/liste_realisateur.html.twig', [
            'realisateurs' => $realisateurs,
        ]);
    }
    /**
     * @Route("/liste_acteur", name="liste_acteur")
     */
    public function listeActeur(ActeurRepository $acteurRepo)
    {
    	$acteurs=$acteurRepo->findAll();
        return $this->render('site/liste_acteur.html.twig', [
            'acteurs' => $acteurs,
        ]);
    }
    /**
     * @Route("/liste_categorie", name="liste_categorie")
     */
    public function listeCategorie(CategorieRepository $categorieRepo)
    {
    	$categories=$categorieRepo->findAll();
        return $this->render('site/liste_categorie.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/liste_ba", name="liste_ba")
     */
    public function listeBA(BandeAnnonceRepository $baRepo)
    {
    	$bandeAnnonces=$baRepo->findAll();
        return $this->render('site/liste_ba.html.twig', [
            'bandeAnnonces' => $bandeAnnonces,
        ]);
    }

    /**
     * @Route("/liste_photo", name="liste_photo")
     */
    public function listePhoto(PhotoRepository $photoRepo)
    {
    	$photos=$photoRepo->findAll();
        return $this->render('site/liste_photo.html.twig', [
            'photos' => $photos,
        ]);
    }
    /**
     * @Route("/liste_sceance", name="liste_sceance")
     */
    public function listeSceance(SceanceRepository $sceanceRepo)
    {
    	$sceances=$sceanceRepo->findAll();
        return $this->render('site/liste_sceance.html.twig', [
            'sceances' => $sceances,
        ]);
    }
    /**
     * @Route("/liste_salle", name="liste_salle")
     */
    public function listeSalle(SalleRepository $salleRepo)
    {
    	$salles=$salleRepo->findAll();
        return $this->render('site/liste_salle.html.twig', [
            'salles' => $salles,
        ]);
    }
    /**
     * @Route("/liste_film", name="liste_film")
     */
    public function listeFilm(FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
        return $this->render('site/liste_film.html.twig', [
            'films' => $films,
        ]);
    }

    /**
     * @Route("/liste_commentaire", name="liste_commentaire")
     */
    public function listeCommentaire(CommentaireRepository $commentaireRepo)
    {
    	$commentaires=$commentaireRepo->findAll();
        return $this->render('site/liste_commentaire.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }


    /**
     * @Route("/realisateur/new", name="realisateur_new", methods={"GET","POST"})
     */
    public function newRealisateur(Request $req,ManagerRegistry $cmanager)
    {
    	$ajout=0;
	  	if ($req->request->get('nom')!=null) {
    		$nom=$req->request->get('nom');
    		$prenom=$req->request->get('prenom');

    		$realisateur=new Realisateur();
    		$realisateur->setNom($nom);
    		$realisateur->setPrenom($prenom);

    		$manager=$cmanager->getManager();
    		$manager->persist($realisateur);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/realisateur_new.html.twig', [
            'ajout' => $ajout,
        ]);
    }
    /**
     * @Route("/acteur/new", name="acteur_new", methods={"GET","POST"})
     */
    public function newActeur(Request $req,ManagerRegistry $cmanager)
    {
    	$ajout=0;
	  	if ($req->request->get('nom')!=null) {
    		$nom=$req->request->get('nom');
    		$prenom=$req->request->get('prenom');
    		$photo=$req->request->get('photo');

    		$acteur=new Acteur();
    		$acteur->setNom($nom);
    		$acteur->setPrenom($prenom);
    		$acteur->setPhoto($photo);

    		$manager=$cmanager->getManager();
    		$manager->persist($acteur);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/acteur_new.html.twig', [
            'ajout' => $ajout,
        ]);
    }
    /**
     * @Route("/categorie/new", name="categorie_new", methods={"GET","POST"})
     */
    public function newCategorie(Request $req,ManagerRegistry $cmanager)
    {
    	$ajout=0;
	  	if ($req->request->get('titre')!=null) {
    		$titre=$req->request->get('titre');
    		$lien=$req->request->get('lien');

    		$categorie=new Categorie();
    		$categorie->setTitre($titre);
    		$categorie->setImage($lien);

    		$manager=$cmanager->getManager();
    		$manager->persist($categorie);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/categorie_new.html.twig', [
            'ajout' => $ajout,
        ]);
    }
    
     /**
     * @Route("/ba/new", name="ba_new", methods={"GET","POST"})
     */
    public function newBandeAnnonce(Request $req,ManagerRegistry $cmanager, FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
    	$ajout=0;
	  	if ($req->request->get('lien')!=null) {
    		$lien=$req->request->get('lien');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);

    		$ba=new BandeAnnonce();
    		$ba->setLien($lien);
    		$ba->setFilm($film);

    		$manager=$cmanager->getManager();
    		$manager->persist($ba);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/ba_new.html.twig', [
            'ajout' => $ajout,
            'films'=>$films,
        ]);
    }
    /**
     * @Route("/photo/new", name="photo_new", methods={"GET","POST"})
     */
    public function newPhoto(Request $req,ManagerRegistry $cmanager, FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
    	$ajout=0;
	  	if ($req->request->get('lien')!=null) {
    		$lien=$req->request->get('lien');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);

    		$photo=new Photo();
    		$photo->setLien($lien);
    		$photo->setFilm($film);

    		$manager=$cmanager->getManager();
    		$manager->persist($photo);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/photo_new.html.twig', [
            'ajout' => $ajout,
            'films'=>$films,
        ]);
    }
    /**
     * @Route("/sceance/new", name="sceance_new", methods={"GET","POST"})
     */
    public function newSceance(Request $req,ManagerRegistry $cmanager, FilmRepository $filmRepo, SalleRepository $salleRepo)
    {
    	$films=$filmRepo->findAll();
    	$salles=$salleRepo->findAll();
    	$ajout=0;
	  	if ($req->request->get('date')!=null) {
    		$date=$req->request->get('date');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);
    		$salle_id=$req->request->get('salle_id');
    		$salle=$salleRepo->find($salle_id);

    		$sceance=new Sceance();
    		$sceance->setDate(new \DateTime($date));
    		$sceance->setFilm($film);
    		$sceance->setSalle($salle);

    		$manager=$cmanager->getManager();
    		$manager->persist($sceance);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/sceance_new.html.twig', [
            'ajout' => $ajout,
             'films'=>$films,
             'salles'=>$salles
        ]);
    }
    /**
     * @Route("/salle/new", name="salle_new", methods={"GET","POST"})
     */
    public function newSalle(Request $req,ManagerRegistry $cmanager)
    {
    	$ajout=0;
	  	if ($req->request->get('nom')!=null) {
    		$nom=$req->request->get('nom');
    		$adresse=$req->request->get('adresse');

    		$salle=new Salle();
    		$salle->setNom($nom);
    		$salle->setAdresse($adresse);

    		$manager=$cmanager->getManager();
    		$manager->persist($salle);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/salle_new.html.twig', [
            'ajout' => $ajout,
        ]);
    }
    /**
     * @Route("/film/new", name="film_new", methods={"GET","POST"})
     */
    public function newFilm(Request $req,ManagerRegistry $cmanager, RealisateurRepository $realisateurRepo)
    {
    	$realisateurs=$realisateurRepo->findAll();
    	$ajout=0;
	  	if ($req->request->get('titre')!=null) {
    		$titre=$req->request->get('titre');
    		$affiche=$req->request->get('affiche');
    		$description=$req->request->get('description');
    		$duree=$req->request->get('duree');
    		$date=$req->request->get('date');
    		$realisateur_id=$req->request->get('realisateur_id');
    		$realisateur=$realisateurRepo->find($realisateur_id);
    		$etat=$req->request->get('etat');


    		$film=new Film();
    		$film->setTitre($titre);
    		$film->setAffiche($affiche);
    		$film->setDescription($description);
    		$film->setDuree($duree);
    		$film->setDateSortie(new \DateTime($date));
    		$film->setRealisateur($realisateur);
    		$film->setEtat($etat);

    		$manager=$cmanager->getManager();
    		$manager->persist($film);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/film_new.html.twig', [
            'ajout' => $ajout,
            'realisateurs'=>$realisateurs,
        ]);
    }
    /**
     * @Route("/commentaire/new", name="commentaire_new", methods={"GET","POST"})
     */
    public function newCommentaire(Request $req,ManagerRegistry $cmanager, FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
    	$ajout=0;
	  	if ($req->request->get('pseudo')!=null) {
    		$pseudo=$req->request->get('pseudo');
    		$date=$req->request->get('date');
    		$note=$req->request->get('note');
    		$com=$req->request->get('commentaire');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);


    		$commentaire=new Commentaire();
    		$commentaire->setPseudo($pseudo);
    		$commentaire->setDate(new \DateTime($date));
    		$commentaire->setNote($note);
    		$commentaire->setCommentaire($com);
    		$commentaire->setFilm($film);


    		$manager=$cmanager->getManager();
    		$manager->persist($commentaire);
    		$manager->flush();
            $ajout=1;
    	}

        return $this->render('site/commentaire_new.html.twig', [
            'ajout' => $ajout,
            'films'=>$films,
        ]);
    }

}
