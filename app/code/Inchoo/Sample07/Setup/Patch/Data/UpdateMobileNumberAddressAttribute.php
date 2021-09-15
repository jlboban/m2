<?php

declare(strict_types=1);

namespace Inchoo\Sample07\Setup\Patch\Data;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class UpdateMobileNumberAddressAttribute implements DataPatchInterface
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
        return [
            CreateMobileNumberAddressAttribute::class
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
     * @return \Magento\Framework\Setup\Patch\PatchInterface
     */
    public function apply()
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();

        $attributeCode = 'mobile_number';
        $entityType = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER;
        $attributeId = (int)$eavSetup->getAttributeId($entityType, $attributeCode);

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
            'customer_address_edit',
            'customer_register_address',
            'adminhtml_customer_address'
        ];

        $formAttributeData = [];
        foreach ($usedInForms as $formCode) {
            $formAttributeData[] = ['form_code' => $formCode, 'attribute_id' => $attributeId];
        }

        $this->moduleDataSetup->getConnection()->insertMultiple($formAttributeTable, $formAttributeData);
    }
}
