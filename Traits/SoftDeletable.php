<?php

namespace SumoCoders\FrameworkMultiUserBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SoftDeletable
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->isDeleted;
    }

    public function delete()
    {
        $this->isDeleted = true;
    }
}
