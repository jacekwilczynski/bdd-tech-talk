<?php

declare(strict_types=1);

namespace App\Essay;

use Psr\EventDispatcher\EventDispatcherInterface;

class SubmitEssay
{
    private ScoringStrategy $scoringStrategy;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(ScoringStrategy $scoringStrategy, EventDispatcherInterface $eventDispatcher)
    {
        $this->scoringStrategy = $scoringStrategy;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(Submission $submission): Evaluation
    {
        $evaluation = $this->evaluate($submission);
        $this->eventDispatcher->dispatch(new SubmissionEvaluatedEvent($submission, $evaluation));

        return $evaluation;
    }

    private function evaluate(Submission $submission): Evaluation
    {
        $score = $this->scoringStrategy->getScore($submission->getContent());

        return new Evaluation($score);
    }
}
