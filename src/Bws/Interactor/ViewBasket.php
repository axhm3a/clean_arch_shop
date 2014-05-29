<?php

namespace Bws\Interactor;

use Bws\Entity\BasketPosition;
use Bws\Repository\BasketPositionRepository;
use Bws\Repository\BasketRepository;

class ViewBasket
{
    /**
     * @var BasketRepository
     */
    private $basketRepository;

    /**
     * @var BasketPositionRepository
     */
    private $positionRepository;

    public function __construct(BasketRepository $basketRepository, BasketPositionRepository $positionRepository)
    {
        $this->basketRepository   = $basketRepository;
        $this->positionRepository = $positionRepository;
    }

    public function execute(ViewBasketRequest $request)
    {
        if (null === $request->getBasketId()) {
            return new ViewBasketResponse(ViewBasketResponse::BAD_BASKET_ID, 'BAD_BASKET_ID');
        }

        $basket = $this->basketRepository->find($request->getBasketId());

        if (!$basket) {
            return new ViewBasketResponse(ViewBasketResponse::BASKET_NOT_FOUND, 'BASKET_NOT_FOUND');
        }

        $positions = $this->positionRepository->findByBasket($basket);

        if (sizeof($positions) == 0) {
            return new ViewBasketResponse(ViewBasketResponse::SUCCESS, '');
        }

        $positionsDto = array();
        $positionCount = 0;
        $total = 0.0;

        /** @var BasketPosition $position */
        foreach ($positions as $position) {
            $positionPrice  = $position->getArticle()->getPrice() * $position->getCount();
            $positionsDto[] = array(
                'articleId'    => $position->getArticle()->getId(),
                'articleTitle' => $position->getArticle()->getTitle(),
                'articlePrice' => $position->getArticle()->getPrice(),
                'articleImage' => $position->getArticle()->getImagePath(),
                'totalPrice'   => $positionPrice,
                'count'        => $position->getCount(),
            );
            $total += $positionPrice;
            $positionCount++;
        }

        // Presenters work normally
        $total = number_format($total, 2);

        return new ViewBasketResponse(ViewBasketResponse::SUCCESS, '', $positionsDto, $total, $positionCount);
    }
}
 