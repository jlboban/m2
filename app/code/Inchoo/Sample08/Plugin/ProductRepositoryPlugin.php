<?php

declare(strict_types=1);

namespace Inchoo\Sample08\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductRepositoryPlugin
{
    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param $result
     * @param string $sku
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     */
    public function afterGet(\Magento\Catalog\Api\ProductRepositoryInterface $subject, $result, $sku, $editMode = false, $storeId = null, $forceReload = false)
    {
        $productName = $result->getName() . 'AFTER';

        $result->setName($productName);
        return $result;
    }

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param $result
     * @param int $productId
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     */
    public function afterGetById(\Magento\Catalog\Api\ProductRepositoryInterface $subject, $result, $productId, $editMode = false, $storeId = null, $forceReload = false)
    {
        $productName = $result->getName() . 'AFTER';

        $result->setName($productName);
        return $result;
    }
}
