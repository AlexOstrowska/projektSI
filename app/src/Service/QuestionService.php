<?php
/**
 * Question service.
 */

namespace App\Service;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class QuestionService.
 */
class QuestionService
{
    /**
     * Question repository.
     *
     * @var \App\Repository\QuestionRepository
     */
    private $QuestionRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * Category service.
     *
     * @var \App\Service\CategoryService
     */
    private $categoryService;

    /**
     * QuestionService constructor.
     *
     * @param \App\Repository\QuestionRepository      $QuestionRepository Question repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     * @param \App\Service\CategoryService            $categoryService Category service
     */
    public function __construct(QuestionRepository $QuestionRepository, PaginatorInterface $paginator, CategoryService $categoryService)
    {
        $this->QuestionRepository = $QuestionRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     * @param array $filters Filters array
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);
        return $this->paginator->paginate(
            $this->QuestionRepository->queryAll($filters),
            $page,
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save Question.
     *
     * @param \App\Entity\question $question Question entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(question $question): void
    {
        $this->QuestionRepository->save($question);
    }

    /**
     * Delete Question.
     *
     * @param \App\Entity\Question $question Question entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(question $question): void
    {
        $this->QuestionRepository->delete($question);
    }

    /**
     * Prepare filters for the Question list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['category']) && is_numeric($filters['category'])) {
            $category = $this->categoryService->findOneById(
                $filters['category']
            );
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }
}