<?php declare(strict_types=1);

namespace Inchoo\Sample03\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

// @codingStandardsIgnoreFile
class Weight extends Template
{
    /**
     * Weight constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
