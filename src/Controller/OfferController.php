<?php

namespace App\Controller;

use App\Controller\Request\Dto\OffersRequestDto;
use App\Service\OffersService;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
final class OfferController extends AbstractController
{
    private SerializerInterface $serializer;
    private OffersService $offersService;

    public function __construct(
        SerializerInterface $serializer,
        OffersService $offersService
    )
    {
        $this->serializer = $serializer;
        $this->offersService = $offersService;
    }

    #[Route('/offers/{id}', name: 'get_offers', methods: 'GET')]
    public function index(int $id): JsonResponse
    {
        return $this->json($this->offersService->getOfferById($id));
    }

    #[Route('/offers', name: 'create_offers', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        $offerDto = $this->serializer->deserialize(
            $request->getContent(),
            OffersRequestDto::class,
            'json');

        $this->offersService->createOffer($offerDto);
        return $this->json([], '204');
    }
}
