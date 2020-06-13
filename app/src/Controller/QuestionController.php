<?php
/**
 * Question controller.
 */

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Answer;
use App\Entity\User;
use App\Form\QuestionType;
use App\Form\AnswerType;
use App\Service\QuestionService;
use App\Service\AnswerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuestionController.
 *
 * @Route("/Question")
 */
class QuestionController extends AbstractController
{
    /**
     * Question service.
     *
     * @var \App\Service\QuestionService
     */
    private $QuestionService;

    private $AnswerService;


    /**
     * QuestionController constructor.
     *
     * @param \App\Service\QuestionService $QuestionService Question service
     */
    public function __construct(QuestionService $QuestionService,AnswerService $AnswerService)
    {
        $this->QuestionService = $QuestionService;
        $this->AnswerService = $AnswerService;

    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="Question_index",
     *
     * )
     *
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->QuestionService->createPaginatedList(
            $page,

            $request->query->getAlnum('filters', [])
        );

        return $this->render(
            'Question/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Question $question Question entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Question_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     */
    public function show(question $question): Response
    {
        return $this->render(
            'Question/show.html.twig',
            ['question' => $question]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="Question_create",
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request): Response
    {
        $question = new question();
        $form = $this->createForm(questionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->QuestionService->save($question);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('Question_index');
        }

        return $this->render(
            'Question/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Question $question Question entity
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
     *     name="Question_edit",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, question $question): Response
    {
        $form = $this->createForm(questionType::class, $question, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->QuestionService->save($question);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('Question_index');
        }

        return $this->render(
            'Question/edit.html.twig',
            [
                'form' => $form->createView(),
                'question' => $question,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Question $question Question entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="Question_delete",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, question $question): Response
    {
        $form = $this->createForm(FormType::class, $question, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->QuestionService->delete($question);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('Question_index');
        }

        return $this->render(
            'Question/delete.html.twig',
            [
                'form' => $form->createView(),
                'question' => $question,
            ]
        );
    }
    /**
     * Delete Answer.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Answer                       $answer Answer entity
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route(
     *     "/{id}/deleteanswer",
     *     methods={"GET", "DELETE"},
     *     name="answer_delete"
     * )
     * @IsGranted("ROLE_ADMIN")
     *
     */
    public function deleteAnswer(Request $request, Answer $answer, $id): Response
    {
        $form = $this->createForm(FormType::class, $answer, ['method' => 'DELETE']);
        $form->handleRequest($request);

        //$question = $questionRepository->find($id); // szuka id książki
        $question = $this->QuestionService->findQuestionId($id);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            //$answerRepository->delete($answer);
            $this->AnswerService->delete($answer);

            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('Question_show', ['id' => $answer->getQuestion()->getId()]); // dzięki temu wie gdzie wrócić
        }

        return $this->render(
            'Question/delete_answer.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
                'question' => $question,
            ]
        );
    }

    /**
     * Add Answer.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route(
     *     "/{id}",
     *     methods={"GET", "POST"},
     *     name="add_answer",
     * )
     */
    public function addAnswer(Request $request, $id): Response
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        //$question = $questionRepository->find($id);
        $question = $this->QuestionService->findQuestionId($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setQuestion($question);
           //* $answer->setUser($this->getUser());*/
            //$answerRepository->save($answer);
            $this->AnswerService->save($answer);

            return $this->redirectToRoute('Question_show', ['id' => $answer->getQuestion()->getId()]); //żeby wiedzieć pod jakie id wrócić
        }

        return $this->render(
            'Question/show.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
                'question' => $question,
            ]
        );
    }


}