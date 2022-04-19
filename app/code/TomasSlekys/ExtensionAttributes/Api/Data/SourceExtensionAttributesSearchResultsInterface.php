<?php

declare(strict_types=1);

namespace TomasSlekys\ExtensionAttributes\Api\Data;

interface SourceExtensionAttributesSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get SourceExtensionAttributes list.
     *
     * @return SourceExtensionAttributesInterface[]
     */
    public function getItems();

    /**
     * Set source_code list.
     *
     * @param SourceExtensionAttributesInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
