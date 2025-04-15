<?php

namespace Sylius\SystempayPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @author Brichard <brichard.zafy@gmail.com>
 * @ORM\Table(name="sylius_systempay_ipn")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class SystempayIpn
{

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * 
     * @ORM\Column(type="string", length=30 , name="order_status")
     * @var ?string
     */
    private ?string $orderStatus = null;

    /**
     * 
     * @ORM\Column(type="string", length=30 , name="shop_id")
     * @var ?string
    */
    private ?string $shopId = null;

    /**
     * 
     * @ORM\Column(type="string", length=30 , name="order_cycle")
     * @var ?string
    */
    private ?string $orderCycle = null;

    /**
     * 
     * @ORM\Column(type="datetime", name="server_date")
     * @var ?\DateTimeInterface
    */
    private ?\DateTimeInterface $serverDate = null;
    /**
     * 
     * @ORM\Column(type="json", name="order_details")
     * @var array
    */
    private array $orderDetails = [];

    /**
     * 
     * @ORM\Column(type="json", name="customer")
     * @var array
    */
    private array $customer = [];

    /**
     * 
     * @ORM\Column(type="json", name="transactions")
     * @var array
    */
    private array $transactions = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): static
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    public function getShopId(): ?string
    {
        return $this->shopId;
    }

    public function setShopId(string $shopId): static
    {
        $this->shopId = $shopId;

        return $this;
    }

    public function getOrderCycle(): ?string
    {
        return $this->orderCycle;
    }

    public function setOrderCycle(string $orderCycle): static
    {
        $this->orderCycle = $orderCycle;

        return $this;
    }

    public function getServerDate(): ?\DateTimeInterface
    {
        return $this->serverDate;
    }

    public function setServerDate(\DateTimeInterface $serverDate): static
    {
        $this->serverDate = $serverDate;

        return $this;
    }

    public function getOrderDetails(): array
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(array $orderDetails): static
    {
        $this->orderDetails = $orderDetails;

        return $this;
    }

    public function getCustomer(): array
    {
        return $this->customer;
    }

    public function setCustomer(array $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function setTransactions(array $transactions): static
    {
        $this->transactions = $transactions;

        return $this;
    }
}
