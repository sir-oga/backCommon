<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Symfony\Bridge\Doctrine\Form\Type;

use Cms\Backend\Common\Symfony\Bridge\Doctrine\Form\ChoiceList\CustomORMQueryBuilderLoader;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;

class EntityTypeExtension extends EntityType implements FormTypeExtensionInterface
{
    /**
     * Return the default loader object.
     *
     * @param ObjectManager $manager
     * @param QueryBuilder $queryBuilder
     * @param string $class
     *
     * @return CustomORMQueryBuilderLoader
     */
    public function getLoader(ObjectManager $manager, $queryBuilder, $class)
    {
        if (!$queryBuilder instanceof QueryBuilder) {
            throw new \TypeError(sprintf(
                'Expected an instance of %s, but got %s.',
                QueryBuilder::class,
                \is_object($queryBuilder) ? \get_class($queryBuilder) : \gettype($queryBuilder)
            ));
        }

        return new CustomORMQueryBuilderLoader($queryBuilder);
    }

    public static function getExtendedTypes()
    {
        return [EntityType::class];
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    /**
     * @inheritDoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
    }

    /**
     * @inheritDoc
     */
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
    }

    /**
     * @inheritDoc
     */
    public function getExtendedType(): array
    {
        return [EntityType::class];
    }
}
