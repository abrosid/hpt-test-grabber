<?php

declare(strict_types=1);

namespace HPT;

class Dispatcher
{
    /** @var Grabber */
    private $grabber;

    /** @var Output */
    private $output;

    public function __construct(Grabber $grabber, Output $output)
    {
        $this->grabber = $grabber;
        $this->output = $output;
    }

    /**
     * @return string JSON
     */
    public function run(): string
    {
        // code here

        return $this->output->getJson();
    }
    
    public function getGrabber(): Grabber {
	return $this->grabber;
    }

    public function getOutput(): Output {
	return $this->output;
    }

    


    
}
