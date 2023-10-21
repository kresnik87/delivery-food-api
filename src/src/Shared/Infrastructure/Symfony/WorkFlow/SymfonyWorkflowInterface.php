<?php

namespace KsK\Shared\Infrastructure\Symfony\WorkFlow;


interface SymfonyWorkflowInterface
{

    public function doTransition(string $transition, object $object): void;
}
