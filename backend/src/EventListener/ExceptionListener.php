<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $status = $exception instanceof HttpException ? $exception->getStatusCode() : 500;

        $response = new JsonResponse([
            'error' => $exception->getMessage(),
            'status' => $status
        ], $status);

        $event->setResponse($response);
    }
}