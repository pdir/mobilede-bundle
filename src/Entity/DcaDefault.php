<?php

declare(strict_types=1);

namespace Pdir\MobileDeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
abstract class DcaDefault
{
    /**
     * @ORM\Column(name="id", type="integer", options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="tstamp", type="integer", options={"unsigned": true, "default": 0})
     */
    protected $timestamp;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Update the entry's timestamp.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function touch(): void
    {
        $this->timestamp = time();
    }
}
