<?php
declare(strict_types=1);

namespace RLTSquare\CustomEmailTemplate\Controller;

use Exception;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use RLTSquare\CustomEmailTemplate\Helper\Email;

/**
 *
 */
class Rltsquare implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected ActionFactory $actionFactory;
    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ActionInterface|null
    {
        $identifier = trim($request->getPathInfo(), '/');
        if (str_contains($identifier, 'rltsquare')) {
            $request->setModuleName('routing'); //module name
            $request->setControllerName('index'); //controller name
            $request->setActionName('index'); //action name
            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );
        }
        return null;
    }
}
