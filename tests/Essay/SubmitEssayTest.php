<?php

declare(strict_types=1);

namespace App\Test\Essay;

use App\Essay\ScoringStrategy;
use App\Essay\Submission;
use App\Essay\SubmissionEvaluatedEvent;
use App\Essay\SubmitEssay;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\EventDispatcher\EventDispatcherInterface;

class SubmitEssayTest extends TestCase
{
    use ProphecyTrait;

    private const STUDENT_ID = '12345';
    private const ESSAY_TEXT = 'essay content';

    /** @var ObjectProphecy|ScoringStrategy */
    private ObjectProphecy $scoringStrategy;

    /** @var ObjectProphecy|EventDispatcherInterface */
    private ObjectProphecy $eventDispatcher;

    private SubmitEssay $submitEssay;

    protected function setUp(): void
    {
        $this->scoringStrategy = $this->prophesize(ScoringStrategy::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);

        $this->submitEssay = new SubmitEssay(
            $this->scoringStrategy->reveal(),
            $this->eventDispatcher->reveal(),
        );
    }

    /** @test */
    public function evaluatesSubmissionAndEmitsEvent(): void
    {
        // given
        $submission = new Submission(self::STUDENT_ID, self::ESSAY_TEXT);
        $expectedScore = 50;
        $this->scoringStrategy->getScore(self::ESSAY_TEXT)->willReturn($expectedScore);

        // when
        $evaluation = $this->submitEssay->execute($submission);

        // then
        self::assertSame($expectedScore, $evaluation->getScore());

        $this->eventDispatcher
            ->dispatch(new SubmissionEvaluatedEvent($submission, $evaluation))
            ->shouldHaveBeenCalledOnce();
    }
}
