<?php

declare(strict_types=1);

namespace Pdir\MobileDeBundle\Entity;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Annotation
 * @ORM\Entity(repositoryClass="Pdir\MobileDeBundle\Repository\VehicleAccountRepository")
 * @ORM\Table(name="tl_vehicle_account")
 */
class VehicleAccount extends DcaDefault
{
    /**
     * @ORM\Column(name="description", type="string", unique=true, options={"default": ""})
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(name="apiType", type="string", options={"default": ""})
     *
     * @var string
     */
    private $apiType;


    /**
     * @ORM\Column(name="enabled", type="boolean", options={"default": false})
     *
     * @var bool
     */
    private $syncEnabled;

    /**
     * @ORM\Embedded(columnPrefix="api_", class="Pdir\MobileDeBundle\Entity\Credentials")
     *
     * @var Credentials
     */
    private $credentials;

    /**
     * @ORM\OneToMany(targetEntity="Pdir\MobileDeBundle\Entity\Vehicle", mappedBy="account")
     *
     * @var Collection|Vehicle[]
     */
    private $vehicles;

    /**
     * VehicleAccount constructor.
     */
    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getApiType(): string
    {
        return $this->apiType;
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    public function isSyncEnabled(): bool
    {
        return $this->syncEnabled;
    }

    /**
     * @return Vehicle[]|Collection
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }
}
