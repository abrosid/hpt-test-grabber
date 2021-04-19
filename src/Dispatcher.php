<?php

declare(strict_types=1);

namespace HPT;

abstract class Dispatcher
{
    /** @var Grabber */
    protected $grabber;

    /** @var Output */
    protected $output;

    public function __construct(Grabber $grabber, Output $output)
    {
        $this->grabber = $grabber;
        $this->output = $output;
    }

    public function run(): string
    {
        return $this->output->getJson();
    }
}
