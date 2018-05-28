<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("user/test" , name="testRoleUser")
     */
    public function testRoleUserAcction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('exemples_roles/hello-world.html.twig');
    }

    /**
     * @Route("admin/test" , name="testRoleAdmin")
     */
    public function testRoleAdminAcction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->getUser()->setEmail('tartru@juniorisen.com');
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->render('exemples_roles/hello-world-admin.html.twig');
    }
}
