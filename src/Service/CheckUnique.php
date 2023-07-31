<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\NonUniqueResultException;

class CheckUnique
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly BookRepository $bookRepository,
    )
    {
    }

    /**
     * @param Author $author
     * @return bool
     * @throws NonUniqueResultException
     */
    public function checkAuthor(Author $author): bool
    {
        $result = $this->authorRepository->checkAuthor($author);

        if ($result === null) {
            return true;
        }
        return false;
    }

    /**
     * @param Book $book
     * @return bool
     * @throws NonUniqueResultException
     */
    public function checkBook(Book $book): bool
    {
        $result = $this->bookRepository->checkBook($book);

        if ($result === null) {
            return true;
        }
        return false;
    }
}