<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Groups({"details"})
     * @ORM\Column(name="tag_name", type="string", length=150, unique=true)
     */
    private $tag_name;

    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags")
     */
    protected $posts;

    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $tag_name
     */
    public function setTagName($tag_name)
    {
        $this->tag_name = $tag_name;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tag_name;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }



}