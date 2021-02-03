<?php

namespace App\Controller;

use App\Entity\Task;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TaskController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    public function index(): Response
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([], ['id'=> 'DESC']);
        
        return $this->render('index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/create", name="task_create", methods={"POST"})
     */
    public function create(Request $request, LoggerInterface $logger): Response
    {
        $title = trim($request->request->get('title'));

        if (empty($title)) {
            return $this->redirectToRoute('todo');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $task = new Task;
        $task->setTitle($title);

        $entityManager->persist($task);
        $entityManager->flush();

        $logger->info('UI: task created');

        return $this->redirectToRoute('todo');
    }

    /**
     * @Route("/update/{id}", name="task_update")
     */
    public function switchStatus($id, LoggerInterface $logger): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $task->setStatus(!$task->getStatus());
        $entityManager->flush();

        $logger->info('UI: task updated');

        return $this->redirectToRoute('todo');
    }

    /**
     * @Route("/delete/{id}", name="task_delete")
     */
    public function delete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('todo');
    }
}
