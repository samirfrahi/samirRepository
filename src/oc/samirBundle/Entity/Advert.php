<?php

namespace oc\samirBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="oc\samirBundle\Entity\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */

class Advert
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
     /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
     private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;
    
    /**
     * @ORM\Column(name="published", type="boolean")
     */
     private $published = true;
     
    /**
    * @ORM\ManyToOne(targetEntity="oc\samirBundle\Entity\Category", inversedBy="advert")
    * @ORM\JoinColumn(nullable=false)
    */
    private $category;

    /**
    * @ORM\Column(name="created", type="datetime")
    */
    public $created = true;
    
      public function __construct()
{
    $this->created         = new \Datetime();
  }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Advert
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
    * @ORM\OneToOne(targetEntity="oc\samirBundle\Entity\Image", cascade={"persist"})
    */
    private $image;

    /**
     * Set image
     *
     * @param \oc\samirBundle\Entity\Image $image
     * @return Advert
     */
    public function setImage(\oc\samirBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \oc\samirBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    private $updatedAt;
    

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
    * @ORM\PrePersist
    */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Advert
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set category
     *
     * @param \oc\samirBundle\Entity\Category $category
     * @return Advert
     */
    public function setCategory(\oc\samirBundle\Entity\Category $category)
    {
        if ($category !== NULL) {
            $category->addAdvert($this); 
        }
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \oc\samirBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
