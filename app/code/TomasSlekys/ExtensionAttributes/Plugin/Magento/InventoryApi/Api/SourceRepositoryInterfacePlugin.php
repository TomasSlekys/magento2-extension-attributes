<?php

declare(strict_types=1);

namespace TomasSlekys\ExtensionAttributes\Plugin\Magento\InventoryApi\Api;

use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\InventoryApi\Api\Data\SourceInterface;
use Magento\InventoryApi\Api\Data\SourceSearchResultsInterface;
use Magento\InventoryApi\Api\SourceRepositoryInterface;
use TomasSlekys\ExtensionAttributes\Api\SourceExtensionAttributesRepositoryInterface;
use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesInterfaceFactory;

class SourceRepositoryInterfacePlugin
{
    private ExtensionAttributesFactory $extensionAttributesFactory;

    private SourceExtensionAttributesRepositoryInterface $sourceExtensionAttributesRepository;

    private SourceExtensionAttributesInterfaceFactory $sourceExtensionAttributesInterfaceFactory;

    public function __construct(
        ExtensionAttributesFactory $extensionAttributesFactory,
        SourceExtensionAttributesRepositoryInterface $sourceExtensionAttributesRepository,
        SourceExtensionAttributesInterfaceFactory $sourceExtensionAttributesInterfaceFactory
    ) {
        $this->extensionAttributesFactory = $extensionAttributesFactory;
        $this->sourceExtensionAttributesRepository = $sourceExtensionAttributesRepository;
        $this->sourceExtensionAttributesInterfaceFactory = $sourceExtensionAttributesInterfaceFactory;
    }

    /**
     * @param SourceRepositoryInterface $subject
     * @param SourceInterface $source
     *
     * @return SourceInterface
     * @author Tomas Slekys
     */
    public function afterGet(
        SourceRepositoryInterface $subject,
        SourceInterface $source
    ): SourceInterface {
        $this->applyExtensionAttributesToEntity($source);

        return $source;
    }

    /**
     * @param SourceRepositoryInterface $subject
     * @param SourceSearchResultsInterface $sourceSearchResults
     *
     * @return SourceSearchResultsInterface
     * @author Tomas Slekys
     */
    public function afterGetList(
        SourceRepositoryInterface $subject,
        SourceSearchResultsInterface $sourceSearchResults
    ): SourceSearchResultsInterface {
        $sources = $sourceSearchResults->getItems();

        foreach ($sources as $source) {
            $this->applyExtensionAttributesToEntity($source);
        }

        return $sourceSearchResults;
    }

    /**
     * @param SourceRepositoryInterface $subject
     * @param SourceInterface $source
     *
     * @return SourceInterface[]
     * @throws LocalizedException
     * @author Tomas Slekys
     */
    public function beforeSave(
        SourceRepositoryInterface $subject,
        SourceInterface $source
    ): array {
        $extensionAttributes = $source->getExtensionAttributes();

        if ($extensionAttributes !== null) {
            $sourceExtensionAttributes = $this->sourceExtensionAttributesRepository
                ->getBySourceCode($source->getSourceCode());

            if ($sourceExtensionAttributes === null) {
                $sourceExtensionAttributes = $this->sourceExtensionAttributesInterfaceFactory->create();
            }

            $sourceExtensionAttributes->setOtherExtensionAttribute($extensionAttributes->getOtherExtensionAttribute());
            $sourceExtensionAttributes->setExampleAttribute($extensionAttributes->getExampleAttribute());
            $sourceExtensionAttributes->setSourceCode($source->getSourceCode());

            $this->sourceExtensionAttributesRepository->save($sourceExtensionAttributes);
        }

        return [$source];
    }

    /**
     * @param SourceInterface $source
     *
     * @author Tomas Slekys
     */
    private function applyExtensionAttributesToEntity(SourceInterface $source): void
    {
        $extensionAttributes = $source->getExtensionAttributes();

        if ($extensionAttributes === null) {
            $extensionAttributes = $this->extensionAttributesFactory
                ->create(SourceInterface::class);

            $source->setExtensionAttributes($extensionAttributes);
        }

        $sourceExtensionAttributes = $this->sourceExtensionAttributesRepository
            ->getBySourceCode($source->getSourceCode());

        if ($sourceExtensionAttributes) {
            $extensionAttributes->setExampleAttribute($sourceExtensionAttributes->getExampleAttribute());
            $extensionAttributes->setOtherExtensionAttribute($sourceExtensionAttributes->getOtherExtensionAttribute());
        }
    }
}
