<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Board;
use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 * @package AppBundle\Controller
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

            $game = $this->getDoctrine()
                ->getRepository(Game::class)
                ->findAll();
            $creatorAff = array();

            foreach ($game as $value) {
                $findCreator = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($value->getCreator());

                array_push($creatorAff, $findCreator);
            }

                return $this->render('AppBundle:Game:index.html.twig', array(
                    'games' => $game,
                    'creator' => $creatorAff

                ));
    }

    /**
     * @Route("/add", name="app_game_add")
     */

    public function addAction(Request $request, Game $game = null)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($game === null) {
            $game = new Game();

            $user = $this->getUser()->getId();
            //La partie est créer est en attende d'un deuxième joueur
            $game->setState(0);
            //Il n'y a pas d'adversaire à la création
            $game->setOpponant(null);
            //Il n'y a pas de gagant à la création
            $game->setWinner(null);
            $game->setCreator($user);
            $game->setBoard(null);

        }
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récupération du manager
            $em = $this->getDoctrine()->getManager();
            //persist the new forum
            $em->persist($game);

            //flush entity manager
            $em->flush();

            $id = $game->getId();

            return $this->redirectToRoute('app_game_play', [
                'id'=>$id
            ]);
        }

        return $this->render('AppBundle:Game:add.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/play{id}", requirements={"id": "\d+"}, name="app_game_play")
     */
    public function playAction($id)
    {

        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($id);
        $board = new Board();
        $board->initGame();

        $opponant = $game->getOpponant();
        $etat = $game->getState();
        $winner = $game->getWinner();

        //On cherche l'id de du créateur de la partie dans la classe User
        $findCreator = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($game->getCreator());
        //Grace à l'id on récupère l'username
        $creatorAff = $findCreator->getUsername();

        if ($opponant != null) {
            //En attente d'un second joueur
            if ($etat == 0) {
                //La partie est en cours
                $game->setState(1);
                //Récupération du manager
                $em = $this->getDoctrine()->getManager();
                //persist the new forum
                $em->persist($game);
                //flush entity manager
                $em->flush();

                return $this->render('AppBundle:Game:play.html.twig', array(
                    'game' => $game,
                     'plateau' => $board->getBoard()
                ));
            }

            //Partie en cours
            if($etat == 1){
                return $this->render('AppBundle:Game:play.html.twig', array(
                    'game' => $game,
                    'creator'=>$creatorAff,
                    'plateau' => $board->getBoard()
                ));

            }

            //La partie est terminée
            else if($etat == 2){
                if($winner != null){
                    return $this->redirectToRoute('app_game_gameover', [
                        'id'=>$id
                    ]);
                }
            }
        }else{
            $board->initGame();
        }
        return $this->render('AppBundle:Game:play.html.twig', array(
            'game' => $game,
            'creator'=>$creatorAff,
            'plateau' => $board->getBoard()


        ));
    }

    /**
     * @Route("/rejoindre{id}", requirements={"id": "\d+"}, name="app_game_rejoindre")
     */
    public function rejoindreAction($id){

        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($id);

        $user = $this->getUser()->getId();
        $game->setOpponant($user);

        //Récupération du manager
        $em = $this->getDoctrine()->getManager();
        //persist the new forum
        $em->persist($game);

        //flush entity manager
        $em->flush();

        return $this->redirectToRoute('app_game_play', [
            'id'=>$id
        ]);
    }


    /**
     * @Route("/remove{id}", requirements={"id" : "\d+"}, name="app_game_remove")
     */
    public function removeAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($game);
        $em->flush();

        return $this->redirectToRoute('homepage', [
            'id'=>$id
        ]);
    }

    /**
     * @Route("/abandon{id}", requirements={"id" : "\d+"}, name="app_game_abandon")
     */
    public function abandonAction($id){

        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($id);

        $user = $this->getUser()->getId();
        $creator = $game->getCreator();
        $opponant = $game->getOpponant();

        if($user == $creator){
            $game->setWinner($opponant);
        }
        else if($user == $opponant){
            $game->setWinner($creator);
        }
        //La partie est terminée
        $game->setState(2);

        //Récupération du manager
        $em = $this->getDoctrine()->getManager();
        //persist the new forum
        $em->persist($game);

        //flush entity manager
        $em->flush();

        return $this->redirectToRoute('app_game_gameover', [
            'id'=>$id
        ]);

    }

    /**
     * @Route("/gameover{id}", requirements={"id" : "\d+"}, name="app_game_gameover")
     */
    public function gameoverAction($id){

        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($id);

        $findWinner = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($game->getWinner());

        $findCreator = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($game->getCreator());

        $winner = $findWinner->getUsername();
        $creator = $findCreator->getUsername();

 return $this->render('AppBundle:Game:gameover.html.twig', array(
            'game' => $game,
            'username' =>$winner,
            'creator'=>$creator


        ));
    }
}
