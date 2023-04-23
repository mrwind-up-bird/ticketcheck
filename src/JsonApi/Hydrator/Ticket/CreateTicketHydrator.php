<?php

namespace App\JsonApi\Hydrator\Ticket;

use App\Entity\Ticket;

/**
 * Create Ticket Hydrator.
 */
class CreateTicketHydrator extends AbstractTicketHydrator
{
    /**
     * {@inheritdoc}
     */
    protected function getAttributeHydrator($ticket): array
    {
        return [
            'ticketId' => function (Ticket $ticket, $attribute, $data, $attributeName) {
                $ticket->setTicketId($attribute);
            },
            'ticketCode' => function (Ticket $ticket, $attribute, $data, $attributeName) {
                $ticket->setTicketCode($attribute);
            },
            'scanTimestamp' => function (Ticket $ticket, $attribute, $data, $attributeName) {
                $ticket->setScanTimestamp($attribute);
            },
            'device' => function (Ticket $ticket, $attribute, $data, $attributeName) {
                $ticket->setDevice($attribute);
            },
        ];
    }
}
