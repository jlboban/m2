<?php

declare(strict_types=1);

namespace Inchoo\Sample07\Setup\Patch\Data;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateOibCustomerAttribute implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * CreateOibCustomerAttribute constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
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

        $attributeCode = 'oib';
        $entityType = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER;
        $setId = CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER;

        $eavSetup->addAttribute($entityType, $attributeCode, [
            'type'           => 'varchar',
            'input'          => 'text',
            'label'          => 'OIB',
            'required'       => 0,
            'user_defined'   => 1, // required for custom attributes
            'system'         => 0, // required for custom attributes
            'sort_order'     => 95, // position in a attribute group
            'position'       => 95, // position in a adminhtml form
            'validate_rules' => '{"input_validation":"other","max_text_length":11,"validate-digits":true}'
        ]);

        $attributeId = (int)$eavSetup->getAttributeId($entityType, $attributeCode);

        $defaultGroupId = $eavSetup->getDefaultAttributeGroupId($entityType, $setId);
        $eavSetup->addAttributeToSet($entityType, $setId, $defaultGroupId, $attributeId);

        $this->createFormAttributeRelations($attributeId);

        return $this;
    }

    /**
     * @param int $attributeId
     * @return void
     */
    protected function createFormAttributeRelations(int $attributeId): void
    {
        $formAttributeTable = $this->moduleDataSetup->getTable('customer_form_attribute');

        $this->moduleDataSetup->getConnection()->delete($formAttributeTable, ['attribute_id = ?' => $attributeId]);

        $usedInForms = [
            'customer_account_create',
            'customer_account_edit',
            'adminhtml_customer'
        ];

        $formAttributeData = [];
        foreach ($usedInForms as $formCode) {
            $formAttributeData[] = ['form_code' => $formCode, 'attribute_id' => $attributeId];
        }

        $this->moduleDataSetup->getConnection()->insertMultiple($formAttributeTable, $formAttributeData);
    }
}
