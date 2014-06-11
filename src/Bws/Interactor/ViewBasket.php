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

    /**
     * @param BasketRepository         $basketRepository
     * @param BasketPositionRepository $positionRepository
     */
    public function __construct(BasketRepository $basketRepository, BasketPositionRepository $positionRepository)
    {
        $this->basketRepository   = $basketRepository;
        $this->positionRepository = $positionRepository;
    }

    /**
     * @param int $basketId
     *
     * @return ViewBasketResponse
     */
    public function execute($basketId)
    {
        if (null === $basketId) {
            return new ViewBasketResponse(ViewBasketResponse::BAD_BASKET_ID, 'BAD_BASKET_ID');
        }

        $basket = $this->basketRepository->find($basketId);

        if (!$basket) {
            return new ViewBasketResponse(ViewBasketResponse::BASKET_NOT_FOUND, 'BASKET_NOT_FOUND');
        }

        $positions = $this->positionRepository->findByBasket($basket);

        if (sizeof($positions) == 0) {
            return new ViewBasketResponse(ViewBasketResponse::SUCCESS, '');
        }

        return $this->buildResponseFromPositions($positions);
    }

    /**
     * @param BasketPosition[] $positions
     *
     * @return ViewBasketResponse
     */
    protected function buildResponseFromPositions(array $positions)
    {
        $positionsDto = array();
        $total        = 0.0;

        $this->buildPositionsDtoAndCalculatePrices($positions, $positionsDto, $total);

        return new ViewBasketResponse(
            ViewBasketResponse::SUCCESS,
            '',
            $positionsDto,
            PriceFormatter::format($total),
            sizeof($positions)
        );
    }

    /**
     * @param array  $positions
     * @param array  $positionsDto
     * @param double $total
     */
    protected function buildPositionsDtoAndCalculatePrices(array $positions, &$positionsDto, &$total)
    {
        /** @var BasketPosition $position */
        foreach ($positions as $position) {
            $positionPrice  = $position->getArticle()->getPrice() * $position->getCount();
            $positionsDto[] = array(
                'articleId'    => $position->getArticle()->getId(),
                'articleTitle' => $position->getArticle()->getTitle(),
                'articlePrice' => PriceFormatter::format($position->getArticle()->getPrice()),
                'articleImage' => $position->getArticle()->getImagePath(),
                'totalPrice'   => PriceFormatter::format($positionPrice),
                'count'        => $position->getCount(),
            );
            $total += $positionPrice;
        }
    }
}
 