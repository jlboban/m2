<?php declare(strict_types=1);

namespace Inchoo\Sample04\Controller\Comment;

use Inchoo\Sample04\Model\CommentFactory;
use Inchoo\Sample04\Model\ResourceModel\Comment as CommentResource;
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
     * @var CommentFactory
     */
    protected $commentFactory;

    /**
     * @var CommentResource;
     */
    protected $commentResource;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * View constructor.
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param CommentFactory $commentFactory
     * @param CommentResource $commentResource
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        CommentFactory $commentFactory,
        CommentResource $commentResource,
        ManagerInterface $messageManager
    ){
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->commentFactory = $commentFactory;
        $this->commentResource = $commentResource;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        if (!$commentId = $this->request->getParam('id')) {
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            return $resultForward->forward('noroute');
        }

        $comment = $this->commentFactory->create();
        $this->commentResource->load($comment, $commentId);

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath("*/news/view/id/{$comment->getData('news_id')}");

        try {
            $this->commentResource->delete($comment);
            $this->messageManager->addSuccessMessage(__('Successfully deleted comment!'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect;
        }

        return $resultRedirect;
    }
}
