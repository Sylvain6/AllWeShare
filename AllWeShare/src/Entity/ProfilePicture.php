<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 21/04/2019
 * Time: 14:03
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilPictureRepository")
 * @ORM\Table("`profil_picture`")
 */

class ProfilePicture extends AbstractController
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={ "image/png" })
     */
    private $picture;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProfilePicture
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     * @return ProfilePicture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    public function __toString()
    {
        return (string) $this->getPicture();
    }
}