<?php
/**
 * Answer controller.
 */

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\FavouriteType;
use App\Service\AnswerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Answer controller.
 *
 * @Route("/answer")
 */
class AnswerController extends AbstractController
{
    /**
     * Answer service
     *
     * @var App\Service\AnswerService
     */
    private $answerService;

    /**
     * AnswerController constructor.
     */
    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * Add Answer action.
     *
     * @param Symfony\Component\HttpFoundation\Request $request  HTTP request
     * @param App\Entity\Question                      $question Question entity selected by id param form URL
     *
     * @return Response HTTP Resposne
     *
     * @Route(
     *     "/{id}/add",
     *     name="add_answer",
     *     methods={"GET", "POST"}
     *     )
     */
    public function add(Request $request, Question $question): Response
    {
        $answer = new Answer();

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setfavourite('0');
            $this->answerService->save($answer, $question);

            return $this->redirectToRoute('Question_show', ['id' => $question->getId()]);
        }

        return $this->render(
            'answer/create.html.twig',
            [
                'id' => $question->getId(),
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * DELETE ANSWER.
     *
     * @param Request $request http request
     * @param Answer  $answer  answer entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/delete/{id}",
     *     name="answer_delete",
     *     methods={"GET", "DELETE"}
     *     )
     */
    public function delete(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(FormType::class, $answer, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->answerService->delete($answer);
            $this->addFlash('success', 'answer deleted');

            return $this->redirectToRoute('Question_index');
        }

        return $this->render(
            'answer/delete.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Answer                        $answer  Answer entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="answer_edit",
     * )
     */
    public function edit(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(FavouriteType::class, $answer, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->answerService->saveFav($answer);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('Question_index');
        }

        return $this->render(
            'answer/edit.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
            ]
        );
    }
}
