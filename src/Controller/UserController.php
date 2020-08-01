<?php

namespace App\Controller;

use App\Message\CreateUserMessage;
use App\Message\DetailUserMessage;
use App\Message\ListUserMessage;
use App\Message\RemoveUserMessage;
use App\Message\UpdateUserMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Route("/users", methods={"GET"})
     */
    public function listAction(): Response
    {

        $response = $this->bus->dispatch(new ListUserMessage());
        return new JsonResponse($response->getMessage()->getData(), Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function detailAction(int $id): Response
    {
        $response = $this->bus->dispatch(new DetailUserMessage($id));
        return new JsonResponse($response->getMessage()->getData(), Response::HTTP_OK);
    }

    /**
     * @Route("/users", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $requestContent = $request->getContent();
        $json = json_decode($requestContent, true);

        $response = $this->bus->dispatch(new CreateUserMessage($json['name'], $json['email'], $json['telephones']));

        return new Response('', Response::HTTP_CREATED, [
            'Location' => '/users/' . $response->getMessage()->getId()
        ]);
    }

    /**
     * @Route("/users/{id}", methods={"PUT"})
     */
    public function updateAction(Request $request, int $id): Response
    {
        $requestContent = $request->getContent();
        $json = json_decode($requestContent, true);

        $this->bus->dispatch(new UpdateUserMessage($id, $json['name'], $json['email']));

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", methods={"DELETE"})
     */
    public function removeAction(int $id): Response
    {
        $this->bus->dispatch(new RemoveUserMessage($id));
        return new Response('', Response::HTTP_OK);
    }

}
