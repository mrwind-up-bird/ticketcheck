<?php

namespace App\JsonApi\Document\Ticket;

use Paknahad\JsonApiBundle\Document\AbstractCollectionDocument;
use WoohooLabs\Yin\JsonApi\Schema\Link\DocumentLinks;

/**
 * Tickets Document.
 */
class TicketsDocument extends AbstractCollectionDocument
{
    /**
     * {@inheritdoc}
     */
    public function getLinks(): ?DocumentLinks
    {
        return DocumentLinks::createWithoutBaseUri()
            ->setPagination('/tickets', $this->object);
    }
}
