<?php


namespace App\Tests\unit\Utilities;



use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class InspectableMessengerDispatcher implements MessageBusInterface
{
    public array $dispatchedMessages = [];

    public function containsMessage($message)
    {
        foreach ($this->dispatchedMessages as $dispatchedMessage) {
            if ($dispatchedMessage == $message) {
                return true;
            }
        }

        return false;
    }

    public function contains(string $className): bool
    {
        foreach ($this->dispatchedMessages as $dispatchedMessage) {
            if (get_class($dispatchedMessage) === $className) {
                return true;
            }
        }

        return false;
    }

    public function dispatch($message, array $stamps = []): Envelope
    {
        $this->dispatchedMessages[] = $message;

        return new Envelope($message);
    }

    public function isEmpty(): bool
    {
        return count($this->dispatchedMessages) === 0;
    }

    public function count(): int
    {
        return count($this->dispatchedMessages);
    }
}
