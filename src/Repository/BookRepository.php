<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param Book $book
     * @return Book|null
     * @throws NonUniqueResultException
     */
    public function checkBook(Book $book): ?Book
    {
        $qb = $this->createQueryBuilder('a');
        return $qb
            ->select()
            ->orWhere(
                $qb->expr()->andX(
                    $qb->expr()->like('a.name', ':name'),
                    $qb->expr()->like('a.ISBN', ':ISBN')
                ),
                $qb->expr()->andX(
                    $qb->expr()->like('a.name', ':name'),
                    $qb->expr()->like('a.yearPublication', ':yearPublication')
                )
            )
            ->setParameters([
                'name' => $book->getName(),
                'ISBN' => $book->getISBN(),
                'yearPublication' => $book->getYearPublication(),
            ])
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
