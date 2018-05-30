<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Board;
use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        return $this->render('AppBundle:Game:index.html.twig', array(
            'games' => $this->getDoctrine()
                ->getRepository(Game::class)
                ->findAll()
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

            return $this->redirectToRoute('app_game_wait', [
                'id' => $id
            ]);
        }

        return $this->render('AppBundle:Game:add.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/wait{id}", requirements={"id": "\d+"}, name="app_game_wait")
     */
    public function waitAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($id);

        if ($game->getBoard() == null) {
            $board = new Board();
            $board->initGame();
            $game->setBoard($board->getSerializable());
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
        }else{
            $board = new Board();
            $board->setBoard(unserialize($game->getBoard()));
        }


        return $this->render('AppBundle:Game:wait.html.twig', array(
            'game' => $this->getDoctrine()
                ->getRepository(Game::class)
                ->find($id),
            'plateau' => $board->getBoard()
        ));
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

        return $this->redirectToRoute('app_game_index', [
            'id' => $id
        ]);
    }
}
