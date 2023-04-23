<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ticketId = null;

    #[ORM\Column(length: 255)]
    private ?string $ticketCode = null;

    #[ORM\Column(nullable: true)]
    private ?int $scanTimestamp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $device = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketId(): ?int
    {
        return $this->ticketId;
    }

    public function setTicketId(int $ticketId): self
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    public function getTicketCode(): ?string
    {
        return $this->ticketCode;
    }

    public function setTicketCode(string $ticketCode): self
    {
        $this->ticketCode = $ticketCode;

        return $this;
    }

    public function getScanTimestamp(): ?int
    {
        return $this->scanTimestamp;
    }

    public function setScanTimestamp(?int $scanTimestamp): self
    {
        $this->scanTimestamp = $scanTimestamp;

        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(?string $device): self
    {
        $this->device = $device;

        return $this;
    }
}
