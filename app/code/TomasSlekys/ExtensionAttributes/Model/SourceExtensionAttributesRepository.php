<?php

declare(strict_types=1);

namespace TomasSlekys\ExtensionAttributes\Model;

use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesInterface;
use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesInterfaceFactory;
use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesSearchResultsInterface;
use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesSearchResultsInterfaceFactory;
use TomasSlekys\ExtensionAttributes\Api\SourceExtensionAttributesRepositoryInterface;
use TomasSlekys\ExtensionAttributes\Model\ResourceModel\SourceExtensionAttributes as ResourceSourceExtensionAttributes;
use TomasSlekys\ExtensionAttributes\Model\ResourceModel\SourceExtensionAttributes\CollectionFactory as SourceExtensionAttributesCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;

class SourceExtensionAttributesRepository implements SourceExtensionAttributesRepositoryInterface
{
    /**
     * @var SourceExtensionAttributes
     */
    protected $searchResultsFactory;

    protected ResourceSourceExtensionAttributes $resource;

    protected SourceExtensionAttributesCollectionFactory $sourceExtensionAttributesCollectionFactory;

    protected CollectionProcessorInterface $collectionProcessor;

    protected SourceExtensionAttributesInterfaceFactory $sourceExtensionAttributesFactory;

    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        ResourceSourceExtensionAttributes $resource,
        SourceExtensionAttributesInterfaceFactory $sourceExtensionAttributesFactory,
        SourceExtensionAttributesCollectionFactory $sourceExtensionAttributesCollectionFactory,
        SourceExtensionAttributesSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resource = $resource;
        $this->sourceExtensionAttributesFactory = $sourceExtensionAttributesFactory;
        $this->sourceExtensionAttributesCollectionFactory = $sourceExtensionAttributesCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param SourceExtensionAttributesInterface $sourceExtensionAttributes
     *
     * @return SourceExtensionAttributesInterface
     * @throws CouldNotSaveException
     * @author Tomas Slekys
     */
    public function save(
        SourceExtensionAttributesInterface $sourceExtensionAttributes
    ): SourceExtensionAttributesInterface
    {
        try {
            $this->resource->save($sourceExtensionAttributes);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the sourceExtensionAttributes: %1', $exception->getMessage())
            );
        }

        return $sourceExtensionAttributes;
    }

    /**
     * @param int $id
     *
     * @return SourceExtensionAttributesInterface|null
     * @author Tomas Slekys
     */
    public function get(int $id): ?SourceExtensionAttributesInterface
    {
        $sourceExtensionAttributes = $this->sourceExtensionAttributesFactory->create();
        $this->resource->load($sourceExtensionAttributes, $id);

        if (!$sourceExtensionAttributes->getId()) {
            return null;
        }

        return $sourceExtensionAttributes;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResults
     * @author Tomas Slekys
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->sourceExtensionAttributesCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];

        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param SourceExtensionAttributesInterface $sourceExtensionAttributes
     *
     * @return bool
     * @throws CouldNotDeleteException
     * @author Tomas Slekys
     */
    public function delete(SourceExtensionAttributesInterface $sourceExtensionAttributes): bool
    {
        try {
            $sourceExtensionAttributesModel = $this->sourceExtensionAttributesFactory->create();

            $this->resource->load($sourceExtensionAttributesModel, $sourceExtensionAttributes->getSourceextensionattributesId());
            $this->resource->delete($sourceExtensionAttributesModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the SourceExtensionAttributes: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @param string $sourceCode
     *
     * @return bool
     * @throws CouldNotDeleteException
     * @author Tomas Slekys
     */
    public function deleteBySourceCode(string $sourceCode): bool
    {
        return $this->delete($this->get($sourceCode));
    }

    /**
     * @param string $sourceCode
     *
     * @return SourceExtensionAttributesInterface|null
     * @author Tomas Slekys
     */
    public function getBySourceCode(string $sourceCode): ?SourceExtensionAttributesInterface
    {
        $sourceExtensionAttributes = $this->getList(
            $this->searchCriteriaBuilder->addFilter('source_code', $sourceCode)->create()
        );

        if ($sourceExtensionAttributes->getTotalCount()) {
            $sourceExtensionAttributeItems = $sourceExtensionAttributes->getItems();

            return array_pop($sourceExtensionAttributeItems);
        }

        return null;
    }
}
