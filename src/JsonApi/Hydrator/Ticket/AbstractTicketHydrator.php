<?php

namespace App\JsonApi\Hydrator\Ticket;

use App\Entity\Ticket;
use Paknahad\JsonApiBundle\Hydrator\AbstractHydrator;

/**
 * Abstract Ticket Hydrator.
 */
abstract class AbstractTicketHydrator extends AbstractHydrator
{
    /**
     * {@inheritdoc}
     */
    protected function getClass(): string
    {
        return Ticket::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAcceptedTypes(): array
    {
        return ['tickets'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getRelationshipHydrator($ticket): array
    {
        return [
        ];
    }
}
