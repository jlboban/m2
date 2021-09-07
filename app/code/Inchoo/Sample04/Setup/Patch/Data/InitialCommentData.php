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
    public static function getDependencies()
    {
        return [
            InitialNewsData::class
        ];
    }

    /**
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply()
    {
        $data = [];
        $query = $this->moduleDataSetup->getConnection()->select()->from('inchoo_news', ['entity_id']);
        $newsIds = $query->query()->fetchAll();

        foreach($newsIds as $newsId) {
            for ($i = 1; $i <= 10; $i++) {
                $data[] = [
                    'news_id'   => $newsId['entity_id'],
                    'comment'  => $this->random->getRandomString(64)
                ];
            }
        }

        $tableName = $this->moduleDataSetup->getTable('inchoo_news_comment');

        $this->moduleDataSetup->startSetup();
        $this->moduleDataSetup->getConnection()->delete($tableName);
        $this->moduleDataSetup->getConnection()->insertMultiple($tableName, $data);
        $this->moduleDataSetup->endSetup();

        return $this;
    }
}
