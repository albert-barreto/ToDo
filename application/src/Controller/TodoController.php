<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\RegisterUserType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class TodoController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $helper)
    {
        return $this->render('login.html.twig', [
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')));
            $user->setEmail($form->get('email')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('todo');
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/", name="todo")
     */
    public function index(): Response
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([], ['id'=> 'DESC']);
        
        return $this->render('index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/create", name="create_task", methods={"POST"})
     */
    public function create(Request $request, LoggerInterface $logger): Response
    {
        $title = trim($request->request->get('title'));

        if(empty($title)) {
            return $this->redirectToRoute('todo_list');
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
     * @Route("/switch-status/{id}", name="switch_status")
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
