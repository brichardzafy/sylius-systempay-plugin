<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\Payum;

/**
 * @author brichard <brichard.zafy@gmail.com>
 * SyliusApi
 */
final class SyliusApi
{
    const MODE_DEV = 0;
    const MODE_PROD = 1;
    /** @var string */
    private $apiKey;
    /** @var string */
    private $userId;
    /** @var string */
    private $publicKey;
    /** @var string */
    private $SHA256Key;
    
    /**
     * password
     *
     * @var string
     */
    private $password;

    /**
     * SyliusApi constructor.
     * @param string $apiKey
     * @param string $userId
     * @param string $publicKey
     * @param string $SHA256Key
     */
    public function __construct(
        string $apiKey, 
        string $userId, 
        string $publicKey, 
        string $SHA256Key,
        string $password = null
    )
    {
        $this->apiKey    = $apiKey;
        $this->userId    = $userId;
        $this->publicKey = $publicKey;
        $this->SHA256Key = $SHA256Key;
        $this->password  = $password;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getSHA256Key(): string
    {
        return $this->SHA256Key;
    }


    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}