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
use Symfony\Component\Validator\Constraints\DateTime;

class SiteController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function dashboard(FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
    	//on recupere les films diffusés lors de ces 7 derniers jours
    	$filmSemaine=0;
    	//date d'il y a 7 jpurs 
        $dateJour = date_create('now');
		$date7=date_sub($dateJour, date_interval_create_from_date_string('7 days'));

    	$affiche=0;
    	$filmMoyenne=array();
    	foreach ($films as $film ) {
    		$moyenne=0;
    		$sommeNote=0;
    		$nbNote=0;
    		if ($film->getEtat() == 1) {
    			$affiche ++;
    		}

    		foreach ($film->getCommentaire() as $commentaire) {
    			$sommeNote+=$commentaire->getNote();
    			$nbNote++;
    		}
    		if ($nbNote!=0) {
    			$moyenne=$sommeNote/$nbNote;
    		}
    		$filmMoyenne[$film->getTitre()]=$moyenne;
    	}
    	$mieuxNote=max($filmMoyenne);
    	$meilleurFilm=array_search(max($filmMoyenne), $filmMoyenne);





        return $this->render('site/dashboard.html.twig', [
            'films'=>$films,
            'date7'=>$date7,
            'affiche'=>$affiche,
            'mieuxNote'=>$mieuxNote,
            'meilleurFilm'=>$meilleurFilm,

        ]);
    }
    /**
     * @Route("/admin/liste_realisateur", name="liste_realisateur")
     */
    public function listeRealisateur(RealisateurRepository $realisateurRepo)
    {
    	$realisateurs=$realisateurRepo->findAll();
        return $this->render('site/liste_realisateur.html.twig', [
            'realisateurs' => $realisateurs,
        ]);
    }
    /**
     * @Route("/admin/liste_acteur", name="liste_acteur")
     */
    public function listeActeur(ActeurRepository $acteurRepo)
    {
    	$acteurs=$acteurRepo->findAll();
        return $this->render('site/liste_acteur.html.twig', [
            'acteurs' => $acteurs,
        ]);
    }
    /**
     * @Route("/admin/liste_categorie", name="liste_categorie")
     */
    public function listeCategorie(CategorieRepository $categorieRepo)
    {
    	$categories=$categorieRepo->findAll();
        return $this->render('site/liste_categorie.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/admin/liste_ba", name="liste_ba")
     */
    public function listeBA(BandeAnnonceRepository $baRepo)
    {
    	$bandeAnnonces=$baRepo->findBy([],['film'=>'ASC']);
        return $this->render('site/liste_ba.html.twig', [
            'bandeAnnonces' => $bandeAnnonces,
        ]);
    }

    /**
     * @Route("/admin/liste_photo", name="liste_photo")
     */
    public function listePhoto(PhotoRepository $photoRepo)
    {
    	$photos=$photoRepo->findBy([],['film'=>'ASC']);
        return $this->render('site/liste_photo.html.twig', [
            'photos' => $photos,
        ]);
    }
    /**
     * @Route("/admin/liste_sceance", name="liste_sceance")
     */
    public function listeSceance(SceanceRepository $sceanceRepo)
    {
    	$sceances=$sceanceRepo->findBy([],['film'=>'ASC']);
        return $this->render('site/liste_sceance.html.twig', [
            'sceances' => $sceances,
        ]);
    }
    /**
     * @Route("/admin/liste_salle", name="liste_salle")
     */
    public function listeSalle(SalleRepository $salleRepo)
    {
    	$salles=$salleRepo->findAll();
        return $this->render('site/liste_salle.html.twig', [
            'salles' => $salles,
        ]);
    }
    /**
     * @Route("/admin/liste_film", name="liste_film")
     */
    public function listeFilm(FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findBy([],['date_sortie'=>'DESC']);
        return $this->render('site/liste_film.html.twig', [
            'films' => $films,
        ]);
    }

    /**
     * @Route("/admin/liste_commentaire", name="liste_commentaire")
     */
    public function listeCommentaire(CommentaireRepository $commentaireRepo)
    {
    	$commentaires=$commentaireRepo->findBy([],['date'=>'DESC']);
        return $this->render('site/liste_commentaire.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }


    /**
     * @Route("/admin/realisateur/new", name="realisateur_new", methods={"GET","POST"})
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
     * @Route("/admin/acteur/new", name="acteur_new", methods={"GET","POST"})
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
     * @Route("/admin/film/acteur/{id}", name="film_acteur", methods={"GET","POST"})
     */
    public function filmActeur(Request $req,ManagerRegistry $cmanager,Film $film, ActeurRepository $acteurRepo)
    {
    	$ajout=0;

	  	if ($req->request->get('acteur_id')!=null) {
    		$acteur_id=$req->request->get('acteur_id');
    		$acteur=$acteurRepo->find($acteur_id);

    		$acteur->addFilm($film);

    		$manager=$cmanager->getManager();
    		$manager->persist($acteur);
    		$manager->flush();
            $ajout=1;
    	}
    	 $acteurs=$acteurRepo->findAll();

        return $this->render('site/film_acteur.html.twig', [
            'ajout' => $ajout,
            'acteurs'=>$acteurs,
            'film'=>$film,

        ]);
    }
    /**
     * @Route("/admin/categorie/new", name="categorie_new", methods={"GET","POST"})
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
     * @Route("/admin/film/categorie/{id}", name="film_categorie", methods={"GET","POST"})
     */
    public function filmCategorie(Request $req,ManagerRegistry $cmanager,Film $film, CategorieRepository $catRepo)
    {
    	$ajout=0;

	  	if ($req->request->get('categorie_id')!=null) {
    		$categorie_id=$req->request->get('categorie_id');
    		$categorie=$catRepo->find($categorie_id);

    		$categorie->addFilm($film);

    		$manager=$cmanager->getManager();
    		$manager->persist($categorie);
    		$manager->flush();
            $ajout=1;
    	}
    	 $categories=$catRepo->findAll();

        return $this->render('site/film_categorie.html.twig', [
            'ajout' => $ajout,
            'categories'=>$categories,
            'film'=>$film,

        ]);
    }
    

    
     /**
     * @Route("/admin/ba/new", name="ba_new", methods={"GET","POST"})
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
     * @Route("/admin/photo/new", name="photo_new", methods={"GET","POST"})
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
     * @Route("/admin/sceance/new", name="sceance_new", methods={"GET","POST"})
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
    		$salle->addFilm($film);

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
     * @Route("/admin/salle/new", name="salle_new", methods={"GET","POST"})
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
     * @Route("/admin/film/new", name="film_new", methods={"GET","POST"})
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
     * @Route("/admin/commentaire/new", name="commentaire_new", methods={"GET","POST"})
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

    /**
     * @Route("/admin/acteur/suppr/{id}", name="acteur_suppr")
     */
    public function acteurSuppr(Acteur $acteur, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($acteur);
		$manager->flush();
		return $this->redirectToRoute('liste_acteur');
    }

    /**
     * @Route("/admin/acteur/modif/{id}", name="acteur_modif" ,  methods={"GET","POST"})
     */
    public function acteurModif(Acteur $acteur, Request $req,ManagerRegistry $cmanager)
    {
    	if ($req->request->get('nom')!=null) {
    		$nom=$req->request->get('nom');
    		$prenom=$req->request->get('prenom');
    		$photo=$req->request->get('photo');

    		$acteur->setNom($nom);
    		$acteur->setPrenom($prenom);
    		$acteur->setPhoto($photo);

	    	$manager=$cmanager->getManager();
			$manager->merge($acteur);
			$manager->flush();
			return $this->redirectToRoute('liste_acteur');
		}

		return $this->render('site/acteur_modif.html.twig', [
            'acteur' => $acteur,
        ]);
    }
    /**
     * @Route("/admin/ba/suppr/{id}", name="ba_suppr")
     */
    public function baSuppr(BandeAnnonce $ba, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($ba);
		$manager->flush();
		return $this->redirectToRoute('liste_ba');
    }

    /**
     * @Route("/admin/ba/modif/{id}", name="ba_modif" ,  methods={"GET","POST"})
     */
    public function baModif(BandeAnnonce $ba, Request $req,ManagerRegistry $cmanager, FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
    	if ($req->request->get('lien')!=null) {
    		$lien=$req->request->get('lien');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);

    		$ba->setLien($lien);
    		$ba->setFilm($film);

	    	$manager=$cmanager->getManager();
			$manager->merge($ba);
			$manager->flush();
			return $this->redirectToRoute('liste_ba');
		}

		return $this->render('site/ba_modif.html.twig', [
            'ba' => $ba,
            'films'=>$films,
        ]);
    }
    /**
     * @Route("/admin/categorie/suppr/{id}", name="categorie_suppr")
     */
    public function categorieSuppr(Categorie $categorie, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($categorie);
		$manager->flush();
		return $this->redirectToRoute('liste_categorie');
    }

    /**
     * @Route("/admin/categorie/modif/{id}", name="categorie_modif" ,  methods={"GET","POST"})
     */
    public function categorieModif(Categorie $categorie, Request $req,ManagerRegistry $cmanager)
    {
    	if ($req->request->get('titre')!=null) {
    		$titre=$req->request->get('titre');
    		$lien=$req->request->get('lien');

    		$categorie->setTitre($titre);
    		$categorie->setImage($lien);

    		$manager=$cmanager->getManager();
    		$manager->merge($categorie);
    		$manager->flush();

			return $this->redirectToRoute('liste_categorie');
		}

		return $this->render('site/categorie_modif.html.twig', [
			'categorie'=>$categorie
        ]);
    }
    /**
     * @Route("/admin/commentaire/suppr/{id}", name="commentaire_suppr")
     */
    public function commentaireSuppr(Commentaire $commentaire, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($commentaire);
		$manager->flush();
		return $this->redirectToRoute('liste_commentaire');
    }

    /**
     * @Route("/admin/commentaire/modif/{id}", name="commentaire_modif" ,  methods={"GET","POST"})
     */
    public function commentaireModif(Commentaire $commentaire, Request $req,ManagerRegistry $cmanager, FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
	  	if ($req->request->get('pseudo')!=null) {
    		$pseudo=$req->request->get('pseudo');
    		$date=$req->request->get('date');
    		$note=$req->request->get('note');
    		$com=$req->request->get('commentaire');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);

    		$commentaire->setPseudo($pseudo);
    		$commentaire->setDate(new \DateTime($date));
    		$commentaire->setNote($note);
    		$commentaire->setCommentaire($com);
    		$commentaire->setFilm($film);

    		$manager=$cmanager->getManager();
    		$manager->merge($commentaire);
    		$manager->flush();

			return $this->redirectToRoute('liste_commentaire');
		}

		return $this->render('site/commentaire_modif.html.twig', [
			'commentaire'=>$commentaire,
			'films'=>$films
        ]);
    }

    /**
     * @Route("/admin/acteurFilm/suppr/{acteur_id}/{film_id}", name="acteurFilm_suppr")
     */
    public function acteurFilmSuppr(Request $req,ManagerRegistry $cmanager,ActeurRepository $acteurRepo, FilmRepository $filmRepo,String $film_id,String $acteur_id)
    {
    	$acteur=$acteurRepo->find($acteur_id);
    	$film=$filmRepo->find($film_id);
    	$film->removeActeur($acteur);
    	$manager=$cmanager->getManager();
		$manager->merge($acteur);
		$manager->flush();

	return $this->redirectToRoute('liste_film');
    }
    /**
     * @Route("/admin/categorieFilm/suppr/{categorie_id}/{film_id}", name="categorieFilm_suppr")
     */
    public function categorieFilmSuppr(Request $req,ManagerRegistry $cmanager,CategorieRepository $categorieRepo, FilmRepository $filmRepo,String $film_id,String $categorie_id)
    {
    	$categorie=$categorieRepo->find($categorie_id);
    	$film=$filmRepo->find($film_id);
    	$film->removeCategorie($categorie);
    	$manager=$cmanager->getManager();
		$manager->merge($categorie);
		$manager->flush();

	return $this->redirectToRoute('liste_film');
    }

    /**
     * @Route("/admin/film/suppr/{id}", name="film_suppr")
     */
    public function filmSuppr(Film $film, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($film);
		$manager->flush();
		return $this->redirectToRoute('liste_film');
    }

    /**
     * @Route("/admin/film/modif/{id}", name="film_modif" ,  methods={"GET","POST"})
     */
    public function filmModif(Request $req,ManagerRegistry $cmanager, RealisateurRepository $realisateurRepo, Film $film)
    {
    	$realisateurs=$realisateurRepo->findAll();
	  	if ($req->request->get('titre')!=null) {
    		$titre=$req->request->get('titre');
    		$affiche=$req->request->get('affiche');
    		$description=$req->request->get('description');
    		$duree=$req->request->get('duree');
    		$date=$req->request->get('date');
    		$realisateur_id=$req->request->get('realisateur_id');
    		$realisateur=$realisateurRepo->find($realisateur_id);
    		$etat=$req->request->get('etat');


    		$film->setTitre($titre);
    		$film->setAffiche($affiche);
    		$film->setDescription($description);
    		$film->setDuree($duree);
    		$film->setDateSortie(new \DateTime($date));
    		$film->setRealisateur($realisateur);
    		$film->setEtat($etat);

    		$manager=$cmanager->getManager();
    		$manager->merge($film);
    		$manager->flush();

			return $this->redirectToRoute('liste_film');
		}

		return $this->render('site/film_modif.html.twig', [
			'realisateurs'=>$realisateurs,
			'film'=>$film,
        ]);
    }
    /**
     * @Route("/admin/photo/suppr/{id}", name="photo_suppr")
     */
    public function photoSuppr(Photo $photo, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($photo);
		$manager->flush();
		return $this->redirectToRoute('liste_photo');
    }

    /**
     * @Route("/admin/photo/modif/{id}", name="photo_modif" ,  methods={"GET","POST"})
     */
    public function photoModif(Photo $photo, Request $req,ManagerRegistry $cmanager, FilmRepository $filmRepo)
    {
    	$films=$filmRepo->findAll();
	  	if ($req->request->get('lien')!=null) {
    		$lien=$req->request->get('lien');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);

    		$photo->setLien($lien);
    		$photo->setFilm($film);

    		$manager=$cmanager->getManager();
    		$manager->merge($photo);
    		$manager->flush();

			return $this->redirectToRoute('liste_photo');
		}

		return $this->render('site/photo_modif.html.twig', [
			'photo'=>$photo,
			'films'=>$films
        ]);
    }
    /**
     * @Route("/admin/realisateur/suppr/{id}", name="realisateur_suppr")
     */
    public function realisateurSuppr(Realisateur $realisateur, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($realisateur);
		$manager->flush();
		return $this->redirectToRoute('liste_realisateur');
    }

    /**
     * @Route("/admin/realisateur/modif/{id}", name="realisateur_modif" ,  methods={"GET","POST"})
     */
    public function realisateurModif(Realisateur $realisateur, Request $req,ManagerRegistry $cmanager)
    {
	  	if ($req->request->get('nom')!=null) {
    		$nom=$req->request->get('nom');
    		$prenom=$req->request->get('prenom');

    		$realisateur->setNom($nom);
    		$realisateur->setPrenom($prenom);

    		$manager=$cmanager->getManager();
    		$manager->merge($realisateur);
    		$manager->flush();

			return $this->redirectToRoute('liste_realisateur');
		}

		return $this->render('site/realisateur_modif.html.twig', [
			'realisateur'=>$realisateur,
        ]);
    }
    /**
     * @Route("/admin/salle/suppr/{id}", name="salle_suppr")
     */
    public function salleSuppr(Salle $salle, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($salle);
		$manager->flush();
		return $this->redirectToRoute('liste_salle');
    }

    /**
     * @Route("/admin/salle/modif/{id}", name="salle_modif" ,  methods={"GET","POST"})
     */
    public function salleModif(Salle $salle, Request $req,ManagerRegistry $cmanager)
    {
	  	if ($req->request->get('nom')!=null) {
    		$nom=$req->request->get('nom');
    		$adresse=$req->request->get('adresse');

    		$salle->setNom($nom);
    		$salle->setAdresse($adresse);

    		$manager=$cmanager->getManager();
    		$manager->merge($salle);
    		$manager->flush();

			return $this->redirectToRoute('liste_salle');
		}

		return $this->render('site/salle_modif.html.twig', [
			'salle'=>$salle,
        ]);
    }
    /**
     * @Route("/admin/sceance/suppr/{id}", name="sceance_suppr")
     */
    public function sceanceSuppr(Sceance $sceance, Request $req,ManagerRegistry $cmanager)
    {

    	$manager=$cmanager->getManager();
		$manager->remove($sceance);
		$manager->flush();
		return $this->redirectToRoute('liste_sceance');
    }

    /**
     * @Route("/admin/sceance/modif/{id}", name="sceance_modif" ,  methods={"GET","POST"})
     */
    public function sceanceModif(Sceance $sceance, Request $req,ManagerRegistry $cmanager,FilmRepository $filmRepo, SalleRepository $salleRepo)
    {
	  	$films=$filmRepo->findAll();
    	$salles=$salleRepo->findAll();

	  	if ($req->request->get('date')!=null) {
    		$date=$req->request->get('date');
    		$film_id=$req->request->get('film_id');
    		$film=$filmRepo->find($film_id);
    		$salle_id=$req->request->get('salle_id');
    		$salle=$salleRepo->find($salle_id);

    		$sceance->setDate(new \DateTime($date));
    		$sceance->setFilm($film);
    		$sceance->setSalle($salle);
    		$salle->addFilm($film);

    		$manager=$cmanager->getManager();
    		$manager->merge($salle);
    		$manager->flush();

			return $this->redirectToRoute('liste_sceance');
		}

		return $this->render('site/sceance_modif.html.twig', [
			'sceance'=>$sceance,
			'films'=>$films,
			'salles'=>$salles
        ]);
    }

}
