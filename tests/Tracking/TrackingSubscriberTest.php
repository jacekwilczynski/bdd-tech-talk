<?php

declare(strict_types=1);

namespace App\Test\Tracking;

use App\Tracking\TrackingSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

class TrackingSubscriberTest extends TestCase
{
    private Request $request;

    protected function setUp(): void
    {
        $this->request = new Request();
        $this->request->setSession(new Session(new MockArraySessionStorage()));
    }

    /** @test */
    public function nothingAddedToSessionIfTrackingIdNotInQueryString(): void
    {
        // given
        $this->queryParamsAre([]);

        // when
        $this->requestEventEmitted();

        // then
        $this->nothingShouldHaveBeenAddedToTheSession();
    }

    /** @test */
    public function trackingIdAddedToSessionIfPresentInQueryString(): void
    {
        // given
        $this->queryParamsAre(['trackingId' => '123']);

        // when
        $this->requestEventEmitted();

        // then
        $this->sessionShouldHaveItem('trackingId', '123');
    }

    private function queryParamsAre(array $queryParams): void
    {
        $this->request->query = new InputBag($queryParams);
    }

    private function requestEventEmitted()
    {
        $event = new RequestEvent(
            $this->createMock(KernelInterface::class),
            $this->request,
            null,
        );

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber(new TrackingSubscriber());
        $eventDispatcher->dispatch($event, KernelEvents::REQUEST);
    }

    private function nothingShouldHaveBeenAddedToTheSession(): void
    {
        self::assertEmpty($this->request->getSession()->all());
    }

    private function sessionShouldHaveItem(string $key, string $value): void
    {
        self::assertSame($value, $this->request->getSession()->get($key));
    }
}
