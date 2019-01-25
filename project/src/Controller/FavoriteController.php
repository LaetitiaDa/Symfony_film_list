<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Favorite;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/favorite", name="favorite")
     */
    public function index()
    {
        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }

    public function favorite(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $favorite = new Favorite();

        $favorite->setFilmID($request->get('id'));
        $favorite->setFilmTitle($request->get('film'));
        $favorite->setUserID($request->cookies->get('my_cookie'));
        $entityManager->persist($favorite);
        $entityManager->flush();

        return $this->render('user/favorite.html.twig', [
            
        ]);  
    }

    public function favoritelist(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Favorite::class);
        $favorite = $repository->findBy(['userID' => $request->cookies->get('my_cookie')]);

        dump($favorite);

        return $this->render('user/favoritelist.html.twig', [
            'favorites' => $favorite,
            ]); 
    }

    public function delete(Request $request)
    {

        //$entityManager = $this->getDoctrine()->getRepository(Favorite::class);
        

        //dump($favorite);

        $entityManager = $this->getDoctrine()->getManager();
        $favorite = new Favorite();
        $favorite = $entityManager->getRepository(Favorite::class)->findBy(['filmID' => $request->get('id')]);

        dump($favorite);
        $entityManager->remove($favorite);
        $entityManager->flush();

        return $this->render('user/delete.html.twig', [
            
            ]); 
    }
}
