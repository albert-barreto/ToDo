<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

/**
 * @Route("/api/tasks", name="api_ task_")
 */
class ApiTaskController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json($this->getDoctrine()->getRepository(Task::class)->findAll(), 200);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        return $this->json($this->getDoctrine()->getManager()->getRepository(Task::class)->find($id), 200);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @param LoggerInterface $logger
     * @return Response
     */
    public function create(Request $request, LoggerInterface $logger): Response
    {
        $title = trim($request->request->get('title'));

        if(empty($title)) {
            return $this->json([
                'data' => 'The title of the task is mandatory.'
            ], 400);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $task = new Task;
        $task->setTitle($title);

        $entityManager->persist($task);
        $entityManager->flush();

        $logger->info('API: created task');

        return $this->json([
            'data' => 'Successfully created task.'
        ], 201);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     * @param int $id
     * @param Request $request
     * @param LoggerInterface $logger
     * @return Response
     */
    public function update(int $id, Request $request, LoggerInterface $logger): Response
    {
        $data = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        if(!$request->request->has('title') || !$request->request->has('status') ) {
            return $this->json([
                'data' => 'The title and status of the task are mandatory.'
            ], 400);
        }

        if($request->request->has('title')) {
            $task->setTitle($data['title']);
        }

        if($request->request->has('status')) {
            $task->setStatus($data['status']);
        }
        $entityManager->flush();

        $logger->info('API: updated task');

        return $this->json([
            'data' => 'Successfully updated task.'
        ], 200);
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
        ], 200);
    }
}
