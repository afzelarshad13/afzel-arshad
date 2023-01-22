<?php
declare(strict_types=1);

namespace RLTSquare\ToDoInstructions\Controller\Save;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Sales\Api\OrderRepositoryInterface;

class Quote implements HttpGetActionInterface
{
    protected QuoteIdMaskFactory $quoteIdMaskFactory;

    /**
     * @var CartRepositoryInterface
     */
    protected CartRepositoryInterface $quoteRepository;
    private RequestInterface $request;
    private OrderRepositoryInterface $orderRepositoryInterface;
    private OrderRepositoryInterface $orderInterface;
    private OrderCollectionFactory $orderCollectionFactory;

    /**
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param CartRepositoryInterface $quoteRepository
     * @param RequestInterface $request
     * @param OrderRepositoryInterface $orderRepositoryInterface
     * @param OrderRepositoryInterface $orderInterface
     * @param OrderCollectionFactory $orderCollectionFactory
     */
    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        CartRepositoryInterface $quoteRepository,
        RequestInterface $request,
        OrderRepositoryInterface $orderRepositoryInterface,
        OrderRepositoryInterface $orderInterface,
        OrderCollectionFactory $orderCollectionFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->request = $request;
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->orderInterface = $orderInterface;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $post = $this->request->getParams();
        if ($post) {
            $cartId = $post['cartId'];
            $todoInstructions = $post['todo_instructions'];
            $loggin = $post['is_customer'];

            if ($loggin === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $quote->setData('todo_instructions', $todoInstructions);
            $this->quoteRepository->save($quote);
        }
    }
}
