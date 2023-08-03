<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @param Author $author
     * @return Author|null
     * @throws NonUniqueResultException
     */
    public function checkAuthor(Author $author): ?Author
    {
        $qb = $this->createQueryBuilder('a');
        return $qb
            ->select()
            ->andWhere(
                $qb->expr()->like('a.name', ':name'),
                $qb->expr()->like('a.surname', ':surname'),
                $qb->expr()->like('a.patronymic', ':patronymic'),
            )
            ->setParameters([
                'name' => $author->getName(),
                'surname' => $author->getSurname(),
                'patronymic' => $author->getPatronymic(),
            ])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
