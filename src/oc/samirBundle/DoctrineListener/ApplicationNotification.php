<?php
// src/oc/samirBundle/DoctrineListener/ApplicationNotification.php

namespace oc\samirBundle\DoctrineListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use oc\samirBundle\Entity\Advert;
use oc\samirBundle\Entity\Image;

class ApplicationNotification
{
  private $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  public function postPersist(LifecycleEventArgs $args)
{
    $entity = $args->getEntity();


    if (!$entity instanceof Advert) {
      return;
    }

    $message = new \Swift_Message(
      'Nouvelle candidature'
    );
    
    
    
    
    $message
      ->addTo($entity->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
      ->setFrom(array('samir.frahi@gmail.com' => 'noreply@monsite.com'));
    
    if(!is_null($entity->getImage())){
            $imageUrl = $entity->getImage()->getUrl();
            $imageAlt = $entity->getImage()->getAlt();
    }
    else{
        $image = new Image();
        $imageUrl = $image->getUrl();
        $imageAlt = $image->getAlt();
    }
    
    
    $message->setBody(
        '<html><head></head><body><br>' . $entity->getTitle() . '<br>Description de la mission: ' . $entity->getContent() . '<br>Poste à pourvoir avant le: ' . $entity->getCreated()->format('d-m-Y H:i:s') . '<br>Référent RH: ' . $entity->getAuthor() . '<br><img src=
        "'  .$imageUrl. '"
        alt="'  .$imageAlt. '" /><br>Posté le : ' . $entity->getUpdatedAt()->format('d-m-Y H:i:s') . '</body></html>','text/html'
);
    
    $message->attach(\Swift_Attachment::fromPath('http://localhost:8888/doc/pdf-exemple.pdf')->setFilename('descriptif-poste.pdf'));
    
    $this->mailer->send($message);
    
    return;
    
  }
  
    public function postLoad(LifecycleEventArgs $args)
{
    $entity = $args->getEntity();


    if (!$entity instanceof Advert) {
      return;
    }

    $message = new \Swift_Message(
      'Nouvelle candidature'
    );
    
    
    
    
    $message
      ->addTo($entity->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
      ->setFrom(array('samir.frahi@gmail.com' => 'noreply@monsite.com'));
    
    if(!is_null($entity->getImage())){
            $imageUrl = $entity->getImage()->getUrl();
            $imageAlt = $entity->getImage()->getAlt();
    }
    else{
        $image = new Image();
        $imageUrl = $image->getUrl();
        $imageAlt = $image->getAlt();
    }
    
    
    $message->setBody(
        '<html><head></head><body><br>' . $entity->getTitle() . '<br>Description de la mission: ' . $entity->getContent() . '<br>Poste à pourvoir avant le: ' . $entity->getCreated()->format('d-m-Y H:i:s') . '<br>Référent RH: ' . $entity->getAuthor() . '<br><img src=
        "'  .$imageUrl. '"
        alt="'  .$imageAlt. '" /><br>Posté le : ' . $entity->getUpdatedAt()->format('d-m-Y H:i:s') . '</body></html>','text/html'
);
    
    $message->attach(\Swift_Attachment::fromPath('http://localhost:8888/doc/pdf-exemple.pdf')->setFilename('descriptif-poste.pdf'));
    
    $this->mailer->send($message);
    
    return;
    
  }
}