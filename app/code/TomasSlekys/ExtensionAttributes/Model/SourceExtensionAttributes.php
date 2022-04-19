<?php

declare(strict_types=1);

namespace TomasSlekys\ExtensionAttributes\Model;

use TomasSlekys\ExtensionAttributes\Api\Data\SourceExtensionAttributesInterface;
use Magento\Framework\Model\AbstractModel;

class SourceExtensionAttributes extends AbstractModel implements SourceExtensionAttributesInterface
{
    public function _construct()
    {
        $this->_init(\TomasSlekys\ExtensionAttributes\Model\ResourceModel\SourceExtensionAttributes::class);
    }

    /**
     * @return int|null
     * @author Tomas Slekys
     */
    public function getId(): ?int
    {
        return $this->getData(self::ID);
    }

    /**
     * @param mixed $value
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setId($value): SourceExtensionAttributes
    {
        return $this->setData(self::ID, $value);
    }

    /**
     * @return string
     * @author Tomas Slekys
     */
    public function getSourceCode(): string
    {
        return $this->getData(self::SOURCE_CODE);
    }

    /**
     * @param string $sourceCode
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setSourceCode(string $sourceCode): SourceExtensionAttributes
    {
        return $this->setData(self::SOURCE_CODE, $sourceCode);
    }

    /**
     * @return string
     * @author Tomas Slekys
     */
    public function getOtherExtensionAttribute(): string
    {
        return $this->getData(self::OTHER_EXTENSION_ATTRIBUTE) ?? '';
    }

    /**
     * @param string $otherExtensionAttribute
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setOtherExtensionAttribute(string $otherExtensionAttribute): SourceExtensionAttributes
    {
        return $this->setData(self::OTHER_EXTENSION_ATTRIBUTE, $otherExtensionAttribute);
    }

    /**
     * @return string
     * @author Tomas Slekys
     */
    public function getExampleAttribute(): string
    {
        return $this->getData(self::EXAMPLE_ATTRIBUTE) ?? '';
    }

    /**
     * @param string $exampleAttribute
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setExampleAttribute(string $exampleAttribute): SourceExtensionAttributes
    {
        return $this->setData(self::EXAMPLE_ATTRIBUTE, $exampleAttribute);
    }
}
