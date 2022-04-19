<?php

declare(strict_types=1);

namespace TomasSlekys\ExtensionAttributes\Api\Data;

use TomasSlekys\ExtensionAttributes\Model\SourceExtensionAttributes;

interface SourceExtensionAttributesInterface
{
    public const ID = 'id';

    public const SOURCE_CODE = 'source_code';

    public const EXAMPLE_ATTRIBUTE = 'example_attribute';

    public const OTHER_EXTENSION_ATTRIBUTE = 'other_extension_attribute';

    /**
     * @return int|null
     * @author Tomas Slekys
     */
    public function getId(): ?int;

    /**
     * @param mixed $value
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setId(int $value): SourceExtensionAttributes;

    /**
     * @return string
     * @author Tomas Slekys
     */
    public function getSourceCode(): string;

    /**
     * @param string $sourceCode
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setSourceCode(string $sourceCode): SourceExtensionAttributes;

    /**
     * @return string
     * @author Tomas Slekys
     */
    public function getOtherExtensionAttribute(): string;

    /**
     * @param string $otherExtensionAttribute
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setOtherExtensionAttribute(string $otherExtensionAttribute): SourceExtensionAttributes;

    /**
     * @return string
     * @author Tomas Slekys
     */
    public function getExampleAttribute(): string;

    /**
     * @param string $exampleAttribute
     *
     * @return SourceExtensionAttributes
     * @author Tomas Slekys
     */
    public function setExampleAttribute(string $exampleAttribute): SourceExtensionAttributes;
}
