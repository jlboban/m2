<?php

declare(strict_types=1);

namespace Inchoo\Sample07\Setup\Patch\Data;

use Inchoo\Sample07\Model\Source\Attribute\Season;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateSeasonProductAttribute implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * CreateCustomIdProductAttribute constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return \Magento\Framework\Setup\Patch\PatchInterface
     */
    public function apply()
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();

        $attributeCode = 'season';
        $entityType = ProductAttributeInterface::ENTITY_TYPE_CODE;

        // create or update attribute
        $eavSetup->addAttribute($entityType, $attributeCode, [
            'type' => 'varchar',
            'input' => 'multiselect',
            'label' => 'Season',
            'source' => Season::class,
            'backend' => ArrayBackend::class,
            'required' => 0,
            'user_defined' => 1,
            'filterable' => 1
        ]);

        foreach ($eavSetup->getAllAttributeSetIds($entityType) as $setId) {
            $defaultGroupId = $eavSetup->getDefaultAttributeGroupId($entityType, $setId);
            $eavSetup->addAttributeToSet($entityType, $setId, $defaultGroupId, $attributeCode);
        }

        return $this;
    }
}
