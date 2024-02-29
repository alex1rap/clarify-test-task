<?php

namespace App\Controller;

use App\Service\TextManagementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TextManagementController extends AbstractController
{

    public function __construct(protected TextManagementService $service)
    {
    }

    #[Route('/api/text/tags', name: 'text_tags', methods: ['POST'])]
    public function tags(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $text = $data['text'];
        $result = $this->service->handleTags($text);
        return $this->json($result);
    }

    #[Route('/api/text/keys', name: 'text_keys', methods: ['POST'])]
    public function keys(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $text = $data['text'];
        $result = $this->service->handleKeys($text);
        return $this->json($result);
    }
}
