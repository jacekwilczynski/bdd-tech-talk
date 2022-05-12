<?php

declare(strict_types=1);

namespace App\Essay;

class Submission
{
    private string $studentId;
    private string $content;

    public function __construct(string $studentId, string $content)
    {
        $this->studentId = $studentId;
        $this->content = $content;
    }

    public function getStudentId(): string
    {
        return $this->studentId;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
