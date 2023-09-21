<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ClientRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findBy(['isValidate' => true]),
        ]);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/all', name: 'app_comment_all', methods: ['GET'])]
    public function all(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    public function createClient($form, ClientRepository $clientRepo) : Client{
        $client = new Client();
        $client->setFirstname($form['firstname']->getData());
        $client->setLastname($form['lastname']->getData());
        $client->setEmail($client->getFirstname().'@'.$client->getLastname().'.parrot');
        $clientRepo->save($client, true);
        return $client;
    }
    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentRepository $commentRepo, ClientRepository $clientRepo, UserRepository $userRepo, MailerInterface $mailer): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $clientRepo->findOneBy(['firstname' => $form['firstname']->getData(), 'lastname' => $form['lastname']->getData()]);
            $user = null;
            if($client == null){
                $user = $userRepo->findOneBy(['firstname' => $form['firstname']->getData(), 'lastname' => $form['lastname']->getData()]);
                if($user == null)
                    $comment->setClient($this->createClient($form, $clientRepo));
                else
                    $comment->setUser($user);
            }else
                $comment->setClient($client);
            // $comment->setIsValidate(false);
            $commentRepo->save($comment, true);
            $this->mail($mailer, "delofongetsongaetan@gmail.com");

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }
    public function mail($mailer, $senderMail){
        $email = (new Email())
            ->from('delofongetsongaetan@gmail.com')
            ->to($senderMail)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Nouveau commentaire posté. Veuillez le valider svp')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/validate/{id}', name: 'app_comment_validate', methods: ['GET'])]
    public function validate(Comment $comment, CommentRepository $commentRepo): Response
    {
        $comment->setIsValidate(true);
        $commentRepo->save($comment, true);
        return $this->redirectToRoute('app_comment_show', ['id' => $comment->getId()]);

    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepo): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepo->save($comment, true);

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepo->save($comment, true);
        }

        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
