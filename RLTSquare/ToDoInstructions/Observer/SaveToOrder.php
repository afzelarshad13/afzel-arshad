<?php
declare(strict_types=1);

namespace RLTSquare\ToDoInstructions\Observer;
class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        $quote = $event->getQuote();
        $order = $event->getOrder();
        $order->setData('todo_instructions', $quote->getData('todo_instructions'));
    }
}
