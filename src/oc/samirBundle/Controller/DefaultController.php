<?php

namespace oc\samirBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        //return $this->render('samirBundle:Default:index.html.twig', array('name' => $name));
        echo phpinfo() ;
    }
}
