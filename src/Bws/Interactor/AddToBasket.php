<?php

namespace Bws\Interactor;

use Bws\Repository\ArticleRepository;
use Bws\Repository\BasketPositionRepository;
use Bws\Repository\BasketRepository;

class AddToBasket
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var BasketRepository
     */
    private $basketRepository;

    /**
     * @var BasketPositionRepository
     */
    private $basketPositionRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        BasketPositionRepository $basketPositionRepository,
        BasketRepository $basketRepository
    ) {
        $this->articleRepository        = $articleRepository;
        $this->basketPositionRepository = $basketPositionRepository;
        $this->basketRepository         = $basketRepository;
    }

    /**
     * @param AddToBasketRequest $request
     *
     * @return AddToBasketResponse
     */
    public function execute(AddToBasketRequest $request)
    {
        if (null === $request->getBasketId()) {
            return new AddToBasketResponse(AddToBasketResponse::BAD_BASKET_ID, 'MISSING_BASKET_ID');
        }

        if (null === $request->getCount() || 0 === $request->getCount()) {
            return new AddToBasketResponse(AddToBasketResponse::ZERO_COUNT, 'ZERO_COUNT');
        }

        if (null === $request->getArticleId()) {
            return new AddToBasketResponse(AddToBasketResponse::BAD_ARTICLE_ID, 'BAD_ARTICLE_ID');
        }

        $article = $this->articleRepository->find($request->getArticleId());

        if (!$article) {
            return new AddToBasketResponse(AddToBasketResponse::ARTICLE_NOT_FOUND, 'ARTICLE_NOT_FOUND');
        }

        $basket = $this->getBasket($request);

        // calc total
        $total                  = 0.0;
        $positionCount          = 0;
        $articleAlreadyInBasket = false;
        $basketPositions        = $this->basketPositionRepository->findByBasket($basket);
        if (sizeof($basketPositions) > 0) {
            foreach ($basketPositions as $pos) {
                $positionCount++;

                if ($pos->getArticle()->getId() == $request->getArticleId()) {
                    $articleAlreadyInBasket = true;
                    $pos->increaseCount($request->getCount());
                    $this->basketPositionRepository->addToBasket($pos);
                }

                $total += $pos->getArticle()->getPrice() * $pos->getCount();
            }
        }

        if (!$articleAlreadyInBasket) {
            $basketPosition = $this->createBasketPosition($request, $article, $basket);
            $this->basketPositionRepository->addToBasket($basketPosition);
            $total += $basketPosition->getArticle()->getPrice() * $basketPosition->getCount();
            $positionCount++;
        }

        return new AddToBasketResponse(AddToBasketResponse::SUCCESS, '', $basket->getId(), $total, $positionCount);
    }

    /**
     * @return \Bws\Entity\Basket
     */
    protected function createAndSaveNewBasket()
    {
        $basket = $this->basketRepository->factory();
        $this->basketRepository->save($basket);
        return $basket;
    }

    /**
     * @param AddToBasketRequest $request
     * @param                    $article
     * @param                    $basket
     *
     * @return \Bws\Entity\BasketPosition
     */
    protected function createBasketPosition(AddToBasketRequest $request, $article, $basket)
    {
        $basketPosition = $this->basketPositionRepository->factory();
        $basketPosition->setArticle($article);
        $basketPosition->setCount($request->getCount());
        $basketPosition->setBasket($basket);
        return $basketPosition;
    }

    /**
     * @param AddToBasketRequest $request
     *
     * @return \Bws\Entity\Basket
     */
    protected function getBasket(AddToBasketRequest $request)
    {
        $basket = $this->basketRepository->find($request->getBasketId());

        if (!$basket) {
            $basket = $this->createAndSaveNewBasket();
        }

        return $basket;
    }
}
 