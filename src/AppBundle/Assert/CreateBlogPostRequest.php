<?php
namespace AppBundle\Assert;

use Symfony\Component\Validator\Constraints as Assert;

class CreateBlogPostRequest
{

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="150")
     * @var string
     */
    public $title;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $text;

    /**
     * @Assert\DateTime()
     * @var \DateTimeImmutable
     */
    public $publishDate;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-zA-Z0-9\-\_]+$/")
     * @var string
     */
    public $slug;

    /**
     * @Assert\NotBlank()
     * @var integer
     */
    public $visible;

    /**
     *
     * @var string
     */
    public $tags;
}