<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM\Mapping;

use Doctrine\ORM\Mapping\NamingStrategy;

class LowerCamelCaseNamingStrategy implements NamingStrategy
{
    /**
     * {@inheritdoc}
     */
    public function classToTableName($className): string
    {
        if (strpos($className, '\\') !== false) {
            $className = substr($className, strrpos($className, '\\') + 1);
        }

        return $this->lower($className);
    }

    /**
     * {@inheritdoc}
     */
    public function propertyToColumnName($propertyName, $className = null): string
    {
        return $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    public function embeddedFieldToColumnName(
        $propertyName,
        $embeddedColumnName,
        $className = null,
        $embeddedClassName = null
    ): string {
        return $propertyName . $this->upper($embeddedColumnName);
    }

    /**
     * {@inheritdoc}
     */
    public function referenceColumnName(): string
    {
        return 'id';
    }

    /**
     * {@inheritdoc}
     */
    public function joinColumnName($propertyName): string
    {
        return $propertyName . $this->upper($this->referenceColumnName());
    }

    /**
     * {@inheritdoc}
     */
    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null): string
    {
        return $this->classToTableName($sourceEntity) . $this->upper($this->classToTableName($targetEntity));
    }

    /**
     * {@inheritdoc}
     */
    public function joinKeyColumnName($entityName, $referencedColumnName = null): string
    {
        return $this->classToTableName($entityName) .
            $this->upper(($referencedColumnName ?: $this->referenceColumnName()));
    }

    private function lower(string $string): string
    {
        return lcfirst($string);
    }

    private function upper(string $string): string
    {
        return ucfirst($string);
    }
}
