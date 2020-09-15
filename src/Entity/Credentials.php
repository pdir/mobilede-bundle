<?php

declare(strict_types=1);

namespace Pdir\MobileDeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Credentials
{
    /**
     * @ORM\Column(name="user_key", type="string", options={"default": ""})
     *
     * @var string
     */
    private $userKey;

    /**
     * @ORM\Column(name="user_secret", type="string", options={"default": ""})
     *
     * @var string
     */
    private $userSecret;

    /**
     * @ORM\Column(name="mobilede_customer_number", type="string", options={"default": ""})
     *
     * @var string
     */
    private $mobiledeCustomerNumber;

    public function __construct(string $consumerKey, string $consumerSecret, string $accessToken, string $accessTokenSecret)
    {
        $this->userKey = $userKey;
        $this->userSecret = $userSecret;
        $this->mobiledeCustomerNumber = $mobiledeCustomerNumber;
    }

    public function getUserKey(): string
    {
        return $this->userKey;
    }

    public function getUserSecret(): string
    {
        return $this->userSecret;
    }

    public function getMobiledeCustomerNumber(): string
    {
        return $this->mobiledeCustomerNumber;
    }
}
