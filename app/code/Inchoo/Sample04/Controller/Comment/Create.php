<?php declare(strict_types=1);

namespace Inchoo\Sample04\Controller\Comment;

use Inchoo\Sample04\Model\ResourceModel\Comment as CommentResource;
use Inchoo\Sample04\Model\CommentFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Math\Random;
use Magento\Framework\Message\ManagerInterface;

class Create implements HttpGetActionInterface
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
     * @var Random
     */
    protected $random;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var CommentResource
     */
    protected $commentResource;

    /**
     * @var CommentFactory
     */
    protected $commentFactory;

    /**
     * Create constructor.
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param Random $random
     * @param ManagerInterface $messageManager
     * @param CommentResource $commentResource
     * @param CommentFactory $commentFactory
     */
    public function __construct(
        RequestInterface $request,
        ResultFactory $resultFactory,
        Random $random,
        ManagerInterface $messageManager,
        CommentResource $commentResource,
        CommentFactory $commentFactory
    ) {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->random = $random;
        $this->messageManager = $messageManager;
        $this->commentResource = $commentResource;
        $this->commentFactory = $commentFactory;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        if (!$newsId = $this->request->getParam('id')) {
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            return $resultForward->forward('noroute');
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath("*/news/view/id/{$newsId}");

        try {
            $randomString = $this->random->getRandomString(64);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__('Could not create a random string.'));
            return $resultRedirect;
        }

        /** @var CommentResource $comment */
        $comment = $this->commentFactory->create();
        $comment->setNewsId($newsId);
        $comment->setContent($randomString);

        try {
            $this->commentResource->save($comment);
            $this->messageManager->addSuccessMessage(__('Successfully created comment!'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect;
        }

        return $resultRedirect;
    }
}
