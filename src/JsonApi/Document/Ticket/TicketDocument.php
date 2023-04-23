<?php

namespace App\JsonApi\Document\Ticket;

use Paknahad\JsonApiBundle\Document\AbstractSingleResourceDocument;
use WoohooLabs\Yin\JsonApi\Schema\Link\DocumentLinks;
use WoohooLabs\Yin\JsonApi\Schema\Link\Link;

/**
 * Ticket Document.
 */
class TicketDocument extends AbstractSingleResourceDocument
{
    /**
     * {@inheritdoc}
     */
    public function getLinks(): ?DocumentLinks
    {
        return DocumentLinks::createWithoutBaseUri(
            [
                'self' => new Link('/tickets/'.$this->getResourceId()),
            ]
        );
    }
}
