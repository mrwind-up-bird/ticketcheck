<?php

namespace App\JsonApi\Transformer;

use App\Entity\Ticket;
use WoohooLabs\Yin\JsonApi\Schema\Link\Link;
use WoohooLabs\Yin\JsonApi\Schema\Link\ResourceLinks;
use WoohooLabs\Yin\JsonApi\Schema\Resource\AbstractResource;

/**
 * Ticket Resource Transformer.
 */
class TicketResourceTransformer extends AbstractResource
{
    /**
     * {@inheritdoc}
     */
    public function getType($ticket): string
    {
        return 'tickets';
    }

    /**
     * {@inheritdoc}
     */
    public function getId($ticket): string
    {
        return (string) $ticket->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta($ticket): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks($ticket): ?ResourceLinks
    {
        return ResourceLinks::createWithoutBaseUri()->setSelf(new Link('/tickets/'.$this->getId($ticket)));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes($ticket): array
    {
        return [
            'ticketId' => function (Ticket $ticket) {
                return $ticket->getTicketId();
            },
            'ticketCode' => function (Ticket $ticket) {
                return $ticket->getTicketCode();
            },
            'scanTimestamp' => function (Ticket $ticket) {
                return $ticket->getScanTimestamp();
            },
            'device' => function (Ticket $ticket) {
                return $ticket->getDevice();
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultIncludedRelationships($ticket): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getRelationships($ticket): array
    {
        return [
        ];
    }
}
