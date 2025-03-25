<?php

namespace App\Tests\Service;

use App\Controller\Request\Dto\OffersRequestDto;
use App\Entity\Offer;
use App\Repository\OfferRepository;
use App\Service\OffersService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OffersServiceTest extends TestCase
{
    private OfferRepository|MockObject $offerRepository;

    public function setUp(): void
    {
        $this->offerRepository = $this->createMock(OfferRepository::class);
    }

    public function testCreateOffer(): void
    {
        $offerDto = (new OffersRequestDto())
            ->setProvider("Test2")
            ->setPrice(1)
            ->setCoverage("Full");

        $offer = (new Offer())
            ->setProvider("Test2")
            ->setPrice(1)
            ->setCoverage("Full");

        $this->offerRepository
            ->expects($this->once())
            ->method("save")
            ->with($offer);


        $service = new OffersService($this->offerRepository);
        $service->createOffer($offerDto);
    }
}
