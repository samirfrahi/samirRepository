<?php

namespace oc\samirBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use oc\samirBundle\Entity\Advert;
use oc\samirBundle\Entity\Image;
use oc\samirBundle\Entity\Category;
use oc\samirBundle\Form\AdvertType;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    public function indexAction($name2)
    {
        $antispam = $this->container->get('oc_samirBundle.antispam');
    if ($antispam->isSpam($name2)) {
      throw new \Exception('Votre message a été détecté comme spam !');
   }
   return $this->render('samirBundle:Test:index1.html.twig', array('name2' => $name2));
    }
    
    public function testonetomanyAction($id)
    {
    $em = $this->getDoctrine()->getManager();
    $categoryRepository = $em->getRepository('samirBundle:Category');
    $category = $categoryRepository->find("6");
    $ad = new Advert();
    $ad->setAuthor("test");
    $ad->setCategory($category);
    $ad->setContent("test");
    $ad->setCreated(new \Datetime());
    $ad->setEmail("samir_frahi@hotmail.fr");
    $ad->setPublished(true);
    $ad->setTitle("test");
    
    $image = new Image();
    $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    $image->setAlt('Job de rêve');
    $ad->setImage($image);
    
    $category->addAdvert($ad);
    
    $em->persist($category);
    
    $em->persist($ad);
    
    $em->flush();

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    //$em->flush();
    
    $Adverts = $category->getAdvert();
    foreach ($Advert as $Adverts) {
        $content .= $Advert->getTitle();
    }
    return $this->render('samirBundle:Test:index1.html.twig', array('name2' => $content));
    }
    
        public function addAction(Request $request, $id)
  {
    // Création de l'entité
    if(is_null($this->getDoctrine()->getManager()->getRepository('samirBundle:Advert')->find($id))){
        $advert = new Advert();
    }
    else{
        $advert = $this->getDoctrine()->getManager()->getRepository('samirBundle:Advert')->find($id);
    }
    
    $form = $this->get('form.factory')->create(new AdvertType(), $advert);
    
    // On fait le lien Requête <-> Formulaire
    // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
    $form->handleRequest($request);
    
    // On vérifie que les valeurs entrées sont correctes
    // (Nous verrons la validation des objets en détail dans le prochain chapitre)
    if ($form->isValid()) {
      // On l'enregistre notre objet $advert dans la base de données, par exemple
      $em = $this->getDoctrine()->getManager();
      $category = new Category();
      $category->setType($advert->getCategory()->getType());
      $category->addAdvert($advert);
      $em->persist($category);
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      // On redirige vers la page de visualisation de l'annonce nouvellement créée
      return $this->redirect($this->generateUrl('samir_pageform', array('id' => $advert->getId())));
    }

    return $this->render('samirBundle:Test:indexformulaire.html.twig', array(
      'form' => $form->createView(),
    ));
  }
    
//    public function addAction($name, $name2)
//  {
    // Création de l'entité
//    $advert = new Advert();
 //   $advert->setTitle($name);
   // $advert->setAuthor($name2);
    //$advert->setContent("enregistrement1");
    //$advert->setCreated(new \Datetime());
    //$advert->setEmail('samir_frahi@hotmail.fr');
    
    // Création de l'entité Image
    //$image = new Image();
    //$image->setUrl('https://www.perfume.com/images/products/brand/medium/Gap.jpg');
    //$image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    //$image->setAlt('Job de rêve');
    
    //$advert->setImage($image);
    
    // Création de l'entité Application1
    //$application1 = new Application();
    //$application1->setAuthor('samir frahi');
    //$application1->setContent('Pas mal');
    //$application1->setDate(new \Datetime());
    //$application1->setAdvert($advert);
    
    // Création de l'entité Application2
    //$application2 = new Application();
    //$application2->setAuthor('samia bahri');
    //$application2->setContent('Jolie');
    //$application2->setDate(new \Datetime());
    //$application2->setAdvert($advert);
    

    // On récupère l'EntityManager
    //$em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    //$em->persist($advert);
    //$em->persist($application1);
    //$em->persist($application2);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    //$em->flush();

    //return $this->render('samirBundle:Test:index2.html.twig', array('name2' => "data persisté"));
  //}
  
  public function selectAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $advertRepository = $em->getRepository('samirBundle:Advert');
    //$Advert = $advertRepository->find($id);
    $Advert = $advertRepository->findByTitle($id);
    if(is_null($Advert)){
        return $this->render('samirBundle:Test:indeximage.html.twig', array('name2' => $Advert->getImage()->getUrl(), 'name' => $Advert->getImage()->getAlt()));
    }
    else{
        $author = "";
        foreach ($Advert as $Ad) {
            $author .= $Ad->getAuthor();
            $advertImage = $Ad;
        }
        $applicationRepository = $em->getRepository('samirBundle:Application');
        $Application = $applicationRepository->findByAdvert($advertImage->getId());
        //return $this->render('samirBundle:Test:index2.html.twig', array('name2' => $Advert->getTitle() . " " . $Advert->getAuthor() . " " . $Advert->getCreated()->format('Y-m-d H:i:s')));
        //return $this->render('samirBundle:Test:index2.html.twig', array('name2' => $author));
        return $this->render('samirBundle:Test:indeximage.html.twig', array('advert' => $advertImage, 'application' => $Application));
    }
  }
  
    public function removeAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $advertRepository = $em->getRepository('samirBundle:Advert');
    //$Advert = $advertRepository->find($id);
    $Advert = $advertRepository->findByTitle($id);
    
    if(is_null($Advert)){
        return $this->render('samirBundle:Test:index2.html.twig', array('name2' => "pas d'enregistrement"));
    }
    else{
        foreach ($Advert as $Ad) {
            $em->remove($Ad);   
        }
        $em->flush(); 
        return $this->render('samirBundle:Test:index2.html.twig', array('name2' => "delete validé"));
    }
  }
}