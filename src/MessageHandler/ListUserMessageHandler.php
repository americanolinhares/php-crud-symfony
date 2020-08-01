<?php

namespace App\MessageHandler;

use App\Entity\Telephone;
use App\Entity\User;
use App\Message\ListUserMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ListUserMessageHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(ListUserMessage $message)
    {
        $users = $this->manager->getRepository(User::class)->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = $this->userToArray($user);
        }

        foreach ($users as $user) {
            $message->setData($this->userToArray($user));
        }

        return new Envelope($message);
    }

    private function userToArray(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'telephones' => array_map(fn(Telephone $telephone) => [
                'number' => $telephone->getNumber()
            ], $user->getTelephones()->toArray())
        ];
    }
}
