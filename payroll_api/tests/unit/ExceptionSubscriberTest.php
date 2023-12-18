<?php

declare(strict_types=1);

namespace App\Tests\unit;

use App\EventSubscriber\ExceptionSubscriber;
use App\Exception\InvalidPayrollRequestException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriberTest extends KernelTestCase
{
    #[\Override]
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testGetSubscribedEvents(): void
    {
        $subscribedEvents = ExceptionSubscriber::getSubscribedEvents();

        $this->assertArrayHasKey(KernelEvents::EXCEPTION, $subscribedEvents);
        $this->assertSame('onKernelException', $subscribedEvents[KernelEvents::EXCEPTION]);
    }

    public function testOnKernelException(): void
    {
        $subscriber = new ExceptionSubscriber();

        $exception = new InvalidPayrollRequestException();

        $event = new ExceptionEvent(
            self::$kernel,
            new Request(),
            1,
            $exception
        );

        $subscriber->onKernelException($event);

        $response = $event->getResponse();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['error' => $exception->getMessage()], json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR));
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
