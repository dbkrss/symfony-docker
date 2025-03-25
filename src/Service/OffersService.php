<?php

namespace App\Service;

use App\Controller\Request\Dto\OffersRequestDto;
use App\Entity\Offer;
use App\Repository\OfferRepository;

class OffersService
{
    private OfferRepository $offerRepository;

    public function __construct(OfferRepository $offerRepository){
        $this->offerRepository = $offerRepository;
    }

    public function getOfferById(int $offerId): Offer
    {
        return $this->offerRepository->findOneById($offerId);
    }

    public function createOffer(OffersRequestDto $offerDto): void
    {
        $offer = (new Offer())
            ->setProvider($offerDto->getProvider())
            ->setPrice($offerDto->getPrice())
            ->setCoverage($offerDto->getCoverage());

        $this->offerRepository->save($offer);
    }
}
