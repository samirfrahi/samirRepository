<?php

namespace oc\samirBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use oc\samirBundle\Entity\Image;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        //return $this->render('samirBundle:Default:index.html.twig', array('name' => $name));
        echo phpinfo() ;
    }
    public function pictureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $imageRepository = $em->getRepository('samirBundle:Image');
        $Image = $imageRepository->find("13");
        return $this->render('samirBundle:Default:index.html.twig', array('name' => $Image->getUploadDir() . '/' . $Image->getUrl()));
        //return $this->render('samirBundle:Default:index.html.twig', array('name' => 'http://www.online-image-editor.com//styles/2014/images/example_image.png'));
    }
}
