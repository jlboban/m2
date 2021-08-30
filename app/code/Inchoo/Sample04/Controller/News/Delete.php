<?php declare(strict_types=1);

namespace Inchoo\Sample04\Controller\News;

use Inchoo\Sample04\Model\NewsFactory;
use Inchoo\Sample04\Model\ResourceModel\News as NewsResource;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;

class Delete implements HttpGetActionInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var NewsFactory
     */
    protected $newsFactory;

    /**
     * @var NewsResource;
     */
    protected $newsResource;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * View constructor.
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param NewsFactory $newsFactory
     * @param NewsResource $newsResource
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        NewsFactory $newsFactory,
        NewsResource $newsResource,
        ManagerInterface $messageManager
    ){
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->newsFactory = $newsFactory;
        $this->newsResource = $newsResource;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        if (!$newsId = $this->request->getParam('id')) {
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            return $resultForward->forward('noroute');
        }

        $news = $this->newsFactory->create();
        $news->setEntityId($newsId);

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/list');

        try {
            $this->newsResource->delete($news);
            $this->messageManager->addSuccessMessage(__('Successfully deleted news!'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect;
        }

        return $resultRedirect;
    }
}
