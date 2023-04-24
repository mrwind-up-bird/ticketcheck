<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\JsonApi\Document\Ticket\TicketDocument;
use App\JsonApi\Document\Ticket\TicketsDocument;
use App\JsonApi\Hydrator\Ticket\CreateTicketHydrator;
use App\JsonApi\Hydrator\Ticket\UpdateTicketHydrator;
use App\JsonApi\Transformer\TicketResourceTransformer;
use App\Repository\TicketRepository;
use Paknahad\JsonApiBundle\Controller\Controller;
use Paknahad\JsonApiBundle\Helper\ResourceCollection;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use WoohooLabs\Yin\JsonApi\Schema\Document\ErrorDocument;
use WoohooLabs\Yin\JsonApi\Schema\Document\ResourceDocumentInterface;

/**
 * TicketController, handles Requests regarding ticket stuff
 *
 * @author Oliver Baer <oliver.baer@gmail.com>
 * @since 2023-24-04
 *
 * @Route("/tickets")
 */
class TicketController extends Controller
{
    /**
     * @Route("/", name="app_tickets_index", methods="GET")
     */
    public function index(TicketRepository $ticketRepository, ResourceCollection $resourceCollection): Response
    {
        $resourceCollection->setRepository($ticketRepository);

        $resourceCollection->handleIndexRequest();

        return $this->respondOk(
            new TicketsDocument(new TicketResourceTransformer()),
            $resourceCollection
        );
    }

    /**
     * handles checkin on an entrance counter
     *
     * if ticket not used before -> setFlag scanTimestamp = currentTimestamp()
     * if used before -> decline operation and show last checkin and checkin entrance
     *
     * finally we're missing the JWT Integration, but times run out ;)
     * https://github.com/lexik/LexikJWTAuthenticationBundle/blob/2.x/Resources/doc/index.rst#installation
     *
     * @Route("/checkin/{ticketCode}", name="app_tickets_checkin", methods="POST")
     * @param Ticket $ticket
     * @param TicketRepository $repository
     * @return Response
     */
    public function checkIn( Ticket $ticket, TicketRepository $repository) : Response
    {
        if ( $ticket->getScanTimestamp() === NULL) {
            $data = ["success" => TRUE];

            $ticket = $repository->findByTicketCode($ticket->getTicketCode());
            $ticket->setScanTimestamp(strtotime("now"));
            $ticket->setDevice("Entrance EAST");

            $ticket = $this->jsonApi()->hydrate(
                new UpdateTicketHydrator($this->entityManager, $this->jsonApi()->getExceptionFactory()),
                $ticket
            );
            try {
                $this->validate($ticket);
                $this->entityManager->flush();
            }
            catch (\Exception $e) {
                $data[] = ["success" => FALSE, "error" => $e->getMessage()];
            }
        } else {
            $data = ["success" => FALSE, "scanTimeStamp" => $ticket->getScanTimestamp()];
        }
        return new JsonResponse($data);
    }

    /**
     * @Route("/", name="app_tickets_new", methods="POST")
     */
    public function new(): Response
    {
        $ticket = $this->jsonApi()->hydrate(
            new CreateTicketHydrator($this->entityManager, $this->jsonApi()->getExceptionFactory()),
            new Ticket()
        );

        $this->validate($ticket);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $this->respondOk(
            new TicketDocument(new TicketResourceTransformer()),
            $ticket
        );
    }

    /**
     * @Route("/{id}", name="app_tickets_show", methods="GET")
     */
    public function show(Ticket $ticket): Response
    {
        return $this->respondOk(
            new TicketDocument(new TicketResourceTransformer()),
            $ticket
        );
    }

}
