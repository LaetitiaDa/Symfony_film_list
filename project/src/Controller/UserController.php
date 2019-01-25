<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function register(Request $request)
    {
        $error = null;

        if(isset($_POST['submit']))
        {
            
            $entityManager = $this->getDoctrine()->getManager();
            $user = new User();
            $reg_mail = " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";
            

            if($request->get('name') == null || $request->get('email') == null || $request->get('password') == null || $request->get('password_conf') == null)
            {
                $error = 'All fields must be filled in';
            }

            else if($request->get('password') != $request->get('password_conf'))
            {
                $error = 'password and password confirmation must be the same';
            }
            
            else if(preg_match($reg_mail,$request->get('email')) == false)
            {
                $error = 'wrong email format';
            }
            
            else
            {
                $user->setName($request->get('name'));
                $user->setEmail($request->get('email'));
                $user->setPassword(password_hash($request->get('password'), PASSWORD_DEFAULT));
                $entityManager->persist($user);
                $entityManager->flush();
            }

        }
        
        return $this->render('user/register.html.twig', [
            'error' => $error,
        ]);  
    }


    public function login(Request $request)
    {
        $error = null;

        if(isset($_POST['submit']))
        {
            
            $repository = $this->getDoctrine()->getRepository(User::class);

            $user = $repository->findOneBy(['email' => $request->get('email')]);

            if(!$user) {
                $error = 'wrong email or password';
            }

            else if(password_verify($request->get('password'), $user->getPassword()) == false) {
                $error = 'wrong email or password';
            }

            else {
                $error = 'You are now logged in';
                $cookie = new Cookie(
                    'my_cookie',	// Cookie name.
                    $user->getId(),	// Cookie value.
                    time() + ( 2 * 365 * 24 * 60 * 60)	// Expires 2 years.
                );
                //send cookie to client
                $res = new Response();
                $res->headers->setCookie( $cookie );
                $res->send();
            }
        }

        return $this->render('user/login.html.twig', [
            'error' => $error,
        ]);  
    }
}
