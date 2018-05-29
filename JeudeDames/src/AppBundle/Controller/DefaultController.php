<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

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
