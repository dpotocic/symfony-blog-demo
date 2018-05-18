<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostTag
 *
 * @ORM\Table(name="blog_post_tag")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class BlogPostTag
{
    /**
     * @var int
     *
     * @ORM\Column(name="blog_post_id", type="integer")
     * @ORM\Id
     */
    private $blog_post_id;

    /**
     * @var int
     *
     * @ORM\Column(name="tag_id", type="integer")
     */
    private $tag_id;

    /**
     * @param int $blog_post_id
     */
    public function setBlogPostId($blog_post_id)
    {
        $this->blog_post_id = $blog_post_id;
    }

    /**
     * @return int
     */
    public function getBlogPostId()
    {
        return $this->blog_post_id;
    }

    /**
     * @param int $tag_id
     */
    public function setTagId($tag_id)
    {
        $this->tag_id = $tag_id;
    }

    /**
     * @return int
     */
    public function getTagId()
    {
        return $this->tag_id;
    }


}