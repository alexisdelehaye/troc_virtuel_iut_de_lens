<?php
namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;

class ObjetSearch {

    /**
     * @var ArrayCollection
     */
    private $users;

    /**
     * @var ArrayCollection
     */
    private $categories;

    /**
     * ObjetSearch constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     * @return ObjetSearch
     */
    public function setUsers(ArrayCollection $users): ObjetSearch
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     * @return ObjetSearch
     */
    public function setCategories(ArrayCollection $categories): ObjetSearch
    {
        $this->categories = $categories;
        return $this;
    }
}