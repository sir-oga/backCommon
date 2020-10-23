<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Symfony\Bridge\Doctrine\Form\ChoiceList;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;

class CustomORMQueryBuilderLoader implements EntityLoaderInterface
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @return array<mixed>|mixed
     */
    public function getEntities()
    {
        return $this->queryBuilder->getQuery()->execute();
    }

    /**
     * @param string $identifier
     * @param array<mixed> $values
     * @return array<mixed>|mixed
     */
    public function getEntitiesByIds($identifier, array $values)
    {
        if (null !== $this->queryBuilder->getMaxResults() || null !== $this->queryBuilder->getFirstResult()) {
            // an offset or a limit would apply on results including the where clause with submitted id values
            // that could make invalid choices valid
            $choices = [];
            $metadata = $this->queryBuilder->getEntityManager()->getClassMetadata(
                current($this->queryBuilder->getRootEntities())
            );

            foreach ($this->getEntities() as $entity) {
                if (\in_array(current($metadata->getIdentifierValues($entity)), $values, true)) {
                    $choices[] = $entity;
                }
            }

            return $choices;
        }

        $qb = clone $this->queryBuilder;
        $alias = current($qb->getRootAliases());
        $parameter = 'ORMQueryBuilderLoader_getEntitiesByIds_' . $identifier;
        $parameter = str_replace('.', '_', $parameter);
        $where = $qb->expr()->in($alias . '.' . $identifier, ':' . $parameter);

        // Guess type
        $entity = current($qb->getRootEntities());
        $metadata = $qb->getEntityManager()->getClassMetadata($entity);
        if (\in_array($metadata->getTypeOfField($identifier), ['integer', 'bigint', 'smallint'])) {
            $parameterType = Connection::PARAM_INT_ARRAY;

            // Filter out non-integer values (e.g. ""). If we don't, some
            // databases such as PostgreSQL fail.
            $values = array_values(array_filter($values, static function ($v) {
                return (string) $v === (string) (int) $v || ctype_digit($v);
            }));
        } elseif (\in_array($metadata->getTypeOfField($identifier), ['uuid', 'guid'])) {
            $parameterType = Connection::PARAM_STR_ARRAY;

            // Like above, but we just filter out empty strings.
            $values = array_values(array_filter($values, static function ($v) {
                return '' !== (string) $v;
            }));
        } else {
            $parameterType = Connection::PARAM_STR_ARRAY;
        }
        if (!$values) {
            return [];
        }

        $values = array_map(static function ($val) {
            return (new \Cms\Backend\Common\Utils\Uuid($val))->toBin();
        }, $values);

        /** @phpstan-ignore-next-line */
        return $qb->andWhere($where)
            ->getQuery()
            ->setParameter($parameter, $values, $parameterType)
            ->getResult();
    }
}
