<?php

declare(strict_types=1);

namespace TomasSlekys\ExtensionAttributes\Api;

use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesInterface;
use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;

interface SourceExtensionAttributesRepositoryInterface
{
    /**
     * @param SourceExtensionAttributesInterface $sourceExtensionAttributes
     *
     * @return SourceExtensionAttributesInterface
     * @throws CouldNotSaveException
     * @author Tomas Slekys
     */
    public function save(
        SourceExtensionAttributesInterface $sourceExtensionAttributes
    ): SourceExtensionAttributesInterface;

    /**
     * @param int $id
     *
     * @return SourceExtensionAttributesInterface|null
     * @author Tomas Slekys
     */
    public function get(int $id): ?SourceExtensionAttributesInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResults
     * @author Tomas Slekys
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * @param SourceExtensionAttributesInterface $sourceExtensionAttributes
     *
     * @return bool
     * @throws CouldNotDeleteException
     * @author Tomas Slekys
     */
    public function delete(SourceExtensionAttributesInterface $sourceExtensionAttributes): bool;

    /**
     * @param string $sourceCode
     *
     * @return bool
     * @throws CouldNotDeleteException
     * @author Tomas Slekys
     */
    public function deleteBySourceCode(string $sourceCode): bool;

    /**
     * @param string $sourceCode
     *
     * @return SourceExtensionAttributesInterface|null
     * @author Tomas Slekys
     */
    public function getBySourceCode(string $sourceCode): ?SourceExtensionAttributesInterface;
}
