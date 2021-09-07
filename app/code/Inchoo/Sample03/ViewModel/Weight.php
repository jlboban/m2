<?php

declare(strict_types=1);

namespace Inchoo\Sample03\ViewModel;

use Magento\Directory\Model\Config\Source\WeightUnit;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Weight
 * @package Inchoo\Sample03\ViewModel
 */
class Weight implements ArgumentInterface
{
    /**
     * @var WeightUnit
     */
    private $weightUnit;

    /**
     * Weight constructor.
     * @param WeightUnit $weightUnit
     */
    public function __construct(WeightUnit $weightUnit)
    {
        $this->weightUnit = $weightUnit;
    }

    /**
     * @return array
     */
    public function getWeightUnits(): array
    {
        return $this->weightUnit->toOptionArray();
    }
}
