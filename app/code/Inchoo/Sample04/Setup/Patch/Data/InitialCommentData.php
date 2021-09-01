<?php

declare(strict_types=1);

namespace Inchoo\Sample04\Setup\Patch\Data;

use Inchoo\Sample04\Model\ResourceModel\News\CollectionFactory;
use Magento\Framework\Math\Random;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InitialCommentData implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var Random
     */
    protected $random;

    /**
     * @var CollectionFactory
     */
    protected $newsCollectionFactory;

    /**
     * InitialNewsData constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param Random $random
     * @param CollectionFactory $newsCollectionFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        Random $random,
        CollectionFactory $newsCollectionFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->random = $random;
        $this->newsCollectionFactory = $newsCollectionFactory;
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            InitialNewsData::class
        ];
    }

    /**
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply(): ?self
    {
        $data = [];
        $collection = $this->newsCollectionFactory->create();
        $newsIds = $collection->getAllIds();

        if (empty($newsIds)) {
            return null;
        }

        for ($i = 0; $i <= 100; $i++) {
            $data[] = [
                'news_id' => array_rand(array_flip($newsIds)),
                'content' => $this->random->getRandomString(64)
            ];
        }

        $tableName = $this->moduleDataSetup->getTable('inchoo_news_comment');

        $this->moduleDataSetup->startSetup();
        $this->moduleDataSetup->getConnection()->delete($tableName);
        $this->moduleDataSetup->getConnection()->insertMultiple($tableName, $data);
        $this->moduleDataSetup->endSetup();

        return $this;
    }
}
