<?php

declare(strict_types=1);

namespace App\Essay;

use Symfony\Contracts\EventDispatcher\Event;

class SubmissionEvaluatedEvent extends Event
{
    private Submission $submission;
    private Evaluation $evaluation;

    public function __construct(Submission $submission, Evaluation $evaluation)
    {
        $this->submission = $submission;
        $this->evaluation = $evaluation;
    }
}
