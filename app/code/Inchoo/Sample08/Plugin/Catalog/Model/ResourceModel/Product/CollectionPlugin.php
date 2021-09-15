<?php

declare(strict_types=1);

namespace Inchoo\Sample08\Plugin\Catalog\Model\ResourceModel\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection;

class CollectionPlugin
{
    /**
     * @param Collection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return array
     */
    public function beforeLoad(Collection $subject, bool $printQuery = false, bool $logQuery = false): array
    {
        if ($printQuery){
            $printQuery = false;
        }

        return [$printQuery, $logQuery];
    }
}
