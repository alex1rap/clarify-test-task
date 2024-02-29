<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Repository\CarrierRepository;
use App\Service\DeliveryCostService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class CarrierController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em, protected CarrierRepository $carrierRepository
    )
    {
    }

    #[Route('/carriers', name: 'carriers', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->carrierRepository->findBy([], ['id' => 'ASC']));
    }

    #[Route('/carriers/{id}', name: 'carriers_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $carrier = $this->carrierRepository->find($id);
        $this->checkCarrier($carrier);
        return $this->json($carrier);
    }

    #[Route('/carriers', name: 'carriers_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $carrier = new Carrier();
        $carrier->setTitle($data['title']);
        $carrier->setDeliveryRules($data['deliveryRules']);
        $this->em->persist($carrier);
        $this->em->flush();
        return $this->json($carrier, 201);
    }

    #[Route('/carriers/{id}', name: 'carriers_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $carrier = $this->carrierRepository->find($id);
        $this->checkCarrier($carrier);
        $data = $request->toArray();
        $carrier->setTitle($data['title']);
        $carrier->setDeliveryRules($data['deliveryRules']);
        $this->em->flush();
        return $this->json($carrier);
    }

    #[Route('/carriers/{id}', name: 'carriers_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $carrier = $this->carrierRepository->find($id);
        $this->checkCarrier($carrier);
        $this->em->remove($carrier);
        $this->em->flush();
        return $this->json(null, 204);
    }

    #[Route('/carriers/{id}/delivery-cost', name: 'carriers_delivery_cost', methods: ['POST'])]
    public function calculateDeliveryCost(Carrier $carrier, Request $request, DeliveryCostService $service): JsonResponse
    {
        $data = $request->toArray();
        $weight = (float)$data['weight'];
        return $this->json($service->handle($carrier, $weight));
    }

    protected function checkCarrier(?Carrier $carrier): void
    {
        if (!$carrier) {
            throw $this->createNotFoundException('The carrier does not exist');
        }
    }
}
