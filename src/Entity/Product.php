<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $releaseOn;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getReleaseOn()
    {
        return $this->releaseOn;
    }

    public function setReleaseOn($releaseOn)
    {
        $this->releaseOn = $releaseOn;
    }

}
