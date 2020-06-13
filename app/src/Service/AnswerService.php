<?php
/**
 * Answer service.
 */

namespace App\Service;

use App\Entity\Answer;
use App\Repository\AnswerRepository;

/**
 * Class AnswerService.
 */
class AnswerService
{
    /**
     * Answer repository.
     *
     * @var \App\Repository\AnswerRepository
     */
    private $AnswerRepository;

    /**
     * AnswerService constructor.
     *
     * @param \App\Repository\AnswerRepository $answerRepository Answer repository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->AnswerRepository = $answerRepository;
    }

    /**
     * Delete answer.
     *
     * @param \App\Entity\Answer $answer Answer entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Answer $answer): void
    {
        $this->AnswerRepository->delete($answer);
    }

    /**
     * Save answer.
     *
     * @param \App\Entity\Answer $answer Answer entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Answer $answer): void
    {
        $this->AnswerRepository->save($answer);
    }
}