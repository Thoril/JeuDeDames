<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 * @package AppBundle\Controller
 * @Route ("/game")
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="app_game_index")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Game:index.html.twig', array(
            'games' =>$this->getDoctrine()
                ->getRepository(Game::class)
                ->findAll()
        ));
    }

    /**
     * @Route("/add", name="app_game_add")
     */
    public function addAction(Request $request)
    {
        if($request->isMethod('post')){
            //Récupération des données de l'user
            $user = $this->getUser();

            //création de la partie
            $game = new Game();
            //Récupération du nom de la partie
            $game->setName($request->get("name"));
            //Etat 0 : la partie est crée et en attente d'un second joueur
            $game->setState(0);
            //A la création il n'y a pas d'adversaire
            $game->setOpponant(null);
            //On récupère l'id du joueur qui créer la partie
            $game->setCreator($user->getId());
            $game->setBoard(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('app_game_index');
        }
        return $this->render('AppBundle:Game:add.html.twig', array(
            // ...
        ));
    }

}
