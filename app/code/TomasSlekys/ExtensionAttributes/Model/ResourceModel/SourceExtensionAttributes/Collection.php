<?php

declare(strict_types=1);

namespace TomasSlekys\ExtensionAttributes\Model\ResourceModel\SourceExtensionAttributes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \TomasSlekys\ExtensionAttributes\Model\SourceExtensionAttributes::class,
            \TomasSlekys\ExtensionAttributes\Model\ResourceModel\SourceExtensionAttributes::class
        );
    }
}
