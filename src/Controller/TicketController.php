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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use WoohooLabs\Yin\JsonApi\Schema\Document\ErrorDocument;
use WoohooLabs\Yin\JsonApi\Schema\Document\ResourceDocumentInterface;

/**
 * TicketController, handles Requests regarding ticket stuff
 *
 * @author Oliver Baer <oliver.baer@gmail.com>
 * @since 2023-20-04
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

    /**
     * @Route("/{id}", name="app_tickets_edit", methods="PATCH")
     */
    public function edit(Ticket $ticket): Response
    {
        $ticket = $this->jsonApi()->hydrate(
            new UpdateTicketHydrator($this->entityManager, $this->jsonApi()->getExceptionFactory()),
            $ticket
        );

        $this->validate($ticket);

        $this->entityManager->flush();

        return $this->respondOk(
            new TicketDocument(new TicketResourceTransformer()),
            $ticket
        );
    }

    /**
     * @Route("/{id}", name="app_tickets_delete", methods="DELETE")
     */
    public function delete(Ticket $ticket): Response
    {
        $this->entityManager->remove($ticket);
        $this->entityManager->flush();

        return $this->respondNoContent();
    }

    /**
     * handles checkin on an entrance counter
     *
     * if ticket not used before -> setFlag scanTimestamp = currentTimestamp()
     * if used before -> decline operation and show last checkin and checkin entrance
     *
     * @Route("/checkin/{ticketCode}", name="app_tickets_checkin", methods="POST")
     *
     * @param TicketCode $ticketCode
     * @return Response
     */
    public function checkIn(string $ticketCode, TicketRepository $ticketRepository, Ticket $ticket) : Response
    {
        if ( $ticket->getScanTimestamp() === NULL) {
            $data = ["success" => TRUE];
            $ticket->setScanTimestamp(strtotime("now"));
            $ticket->setDevice("Entrance EAST");

            $ticket = $this->jsonApi()->hydrate(
                new UpdateTicketHydrator($this->entityManager, $this->jsonApi()->getExceptionFactory()),
                $ticket
            );
            dd($ticket);
//            $this->validate($ticket);

//            $this->entityManager->flush();

//            return $this->respondOk(
//                new TicketDocument(new TicketResourceTransformer()),
//                $ticket
//            );
        } else {
            $data = ["success" => FALSE, "scanTimeStamp" => $ticket->getScanTimestamp()];
        }




        print_r($data);
        dd($ticket);




        return $this->responseCheckInFailed(
            new TicketDocument(new TicketResourceTransformer()), $ticket
        );


//        return $this->respondOk(
//            new TicketDocument(new TicketResourceTransformer()),
//            $ticket
//        );
    }

    private function responseCheckInFailed(ResourceDocumentInterface $document, $object) : Response {
        return $this->respond(
            $this->jsonApi()->respond()->conflict($document, $object)
        );
    }


    private function responseCheckInOk(ResourceDocumentInterface $document, $object, $meta) : Response {
        return $this->respond(
            $this->jsonApi()->respond()->ok($document, $object)
        );
    }
}
