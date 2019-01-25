<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Twig\Environment;
use App\Entity\Lists;
use App\Repository\ListsRepository;
//use Unirest\Request;
//require_once '../vendor/autoload.php';


class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function search(Request $request)
    {

        if(isset($_POST['submit']))
        {

            $film = $request->get('film');
            $year = $request->get('year');

            $headers = array('Accept' => 'application/json');
            $query = array('s' => $film, 'y' => $year);
    
            $response = \Unirest\Request::get('http://www.omdbapi.com/?apikey=4a6205a3', $headers, $query);

            dump($response);

        
        return $this->render('user/search.html.twig', [
            'responses' => $response->body->Search
        ]);

        }
        else
        {
            return $this->render('user/search.html.twig', [
                'responses' => 'search for a film',
            ]);
        }
        
    }

    public function detail(Request $request)
    {

        $id = $request->get('id');

        $headers = array('Accept' => 'application/json');
        $query = array('i' => $id);
    
        $response = \Unirest\Request::get('http://www.omdbapi.com/?apikey=4a6205a3', $headers, $query);

        dump($response);

        return $this->render('user/detail.html.twig', [
            'response' => $response->body
        ]);
    }

}

