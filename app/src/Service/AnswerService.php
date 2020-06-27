<?php
/**
 * Answer service.
 */

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
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
    private $answerRepository;

    /**
     * AnswerService constructor.
     *
     * @param \App\Repository\AnswerRepository $answerRepository Answer repository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * Save answer.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Answer $answer, Question $question): void
    {
        if ($answer instanceof  Answer) {
            if ($question instanceof Question) {
                $answer->setQuestion($question);
                $this->answerRepository->save($answer);
            }
        }
    }

    /**
     * Save Favanswer.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveFav(Answer $answer): void
    {
        if ($answer instanceof  Answer) {
            $this->answerRepository->saveFav($answer);
        }
    }

    /**
     * Delete answer.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Answer $answer): void
    {
        $this->answerRepository->delete($answer);
    }
}
