<?php

// @codingStandardsIgnoreFile
// Ignored due to undefined return type in aroundInstall()

declare(strict_types=1);

namespace Inchoo\Sample08\Plugin\Customer\Setup;

use Magento\Customer\Setup\RecurringData;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class RecurringDataPlugin
{
    /**
     * @param RecurringData $subject
     * @param callable $proceed
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function aroundInstall(RecurringData $subject, callable $proceed, ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
    }
}
