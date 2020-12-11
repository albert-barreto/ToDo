<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/tasks", name="task_")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([], ['id'=> 'DESC']);

        return $this->json([
            'data' => $tasks
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        return $this->json([
            'data' => $task
        ]);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $title = trim($request->request->get('title'));

        if(empty($title)) {
            return $this->json([
                'data' => 'The title of the task is mandatory.'
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $task = new Task;
        $task->setTitle($title);

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->json([
            'data' => 'Successfully created task.'
        ]);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function update(int $id, Request $request): Response
    {
        $data = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        if($request->request->has('title')) {
            $task->setTitle($data['title']);
        }

        if($request->request->has('status')) {
            $task->setStatus($data['status']);
        }
        $entityManager->flush();

        return $this->json([
            'data' => 'Successfully updated task.'
        ]);
    }

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function remove(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->json([
            'data' => 'Successfully removed task.'
        ]);
    }
}
