<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\CustomerDeletedException;
use App\Http\Exception\NotValidatedHttpException;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $request = $event->getRequest();

        $e = $event->getThrowable();

        $data = $this->getExceptionResponseData($e);

        $event->setResponse(new JsonResponse($data, $data['code']));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * @throws Exception
     */
    private function getExceptionResponseData(Throwable $e): array
    {
        $error = [
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => JsonResponse::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
        ];

        if ($e instanceof HttpException) {
            $error['code'] = $e->getStatusCode();
            $error['message'] = $e->getMessage();
        }

        if (getenv('APP_ENV') !== 'prod') {
            $error['message'] = $e->getMessage();
        }

        return $error;
    }
}
