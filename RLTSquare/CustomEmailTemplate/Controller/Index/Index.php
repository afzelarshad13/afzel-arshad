<?php
declare(strict_types=1);

namespace RLTSquare\CustomEmailTemplate\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use RLTSquare\CustomEmailTemplate\Helper\Email;

/**
 * Custom Controller for sending email
 */
class Index implements HttpGetActionInterface
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;
    /**
     * @var StoreManagerInterface
     */

    protected StoreManagerInterface $storeManager;
    /**
     * @var TransportBuilder
     */

    protected TransportBuilder $transportBuilder;
    /**
     * @var StateInterface
     */
    protected StateInterface $state;
    /**
     * @var Email
     */
    protected Email $email;
    /**
     * @var PageFactory
     */
    protected PageFactory $pageFactory;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param Context $context
     * @param LoggerInterface $logger
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $state
     * @param Email $email
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        StateInterface $state,
        Email $email,
        PageFactory $pageFactory,
        RequestInterface $request
    ) {
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->state = $state;
        $this->email = $email;
        $this->pageFactory = $pageFactory;
        $this->request = $request;
    }

    /**
     * Execute action based on request and return result
     *
     * @return Page
     */
    public function execute(): Page
    {
        $this->SendMail();
        return $this->pageFactory->create();
    }

    /**
     * @return void
     */
    public function SendMail(): void
    {
        $this->logger->info('Page Visited Controller');
        try {
            if ($this->email->getEnableFlag()) {
                $name = $this->email->getName();
                $email = $this->email->getEmail();
                (int)$template = $this->email->getCustomEmailTemplateId();
                $templateOptions = [
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId()
                ];
                $templateVars = [
                    'store' => $this->storeManager->getStore(),
                    'customer_name' => 'Pyaray Afzel',
                    'message' => 'Custom Email Template!!.'
                ];
                $from = ['email' => $email, 'name' => $name];
                $this->state->suspend();
                $to = ['afzal.arshad@rltsquare.com'];
                $transport = $this->transportBuilder->setTemplateIdentifier($template)
                    ->setTemplateOptions($templateOptions)
                    ->setTemplateVars($templateVars)
                    ->setFromByScope($from)
                    ->addTo($to)
                    ->getTransport();
                $transport->sendMessage();
                $this->state->resume();
            }
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
