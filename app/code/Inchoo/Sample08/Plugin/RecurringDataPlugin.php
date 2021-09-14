<?php

declare(strict_types=1);

namespace Inchoo\Sample08\Plugin;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class RecurringDataPlugin
{
    /**
     * @param \Magento\Customer\Setup\RecurringData $subject
     * @param callable $proceed
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function aroundInstall(\Magento\Customer\Setup\RecurringData $subject, callable $proceed, ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
    }
}
