<?php

namespace App\EventListener;

use App\Exception\ApiException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ApiException) {
            return;
        }

        $data = [
            'errors' => [
                [
                    'status' => $exception->getStatusCode(),
                    'title' => $exception->getMessage(),
                ],
            ],
        ];

        $response = new JsonResponse($data, $exception->getStatusCode());
        $event->setResponse($response);
    }
}