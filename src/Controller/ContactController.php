<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ClientRepository;
use App\Repository\ContactRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/contact')]
class ContactController extends AbstractController
{
    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }
    public function createClient($form, $client, ClientRepository $clientRepo)
    {
        $client = new Client();
        $client->setFirstname($form['sender_firstname']->getData());
        $client->setLastname($form['sender_lastname']->getData());
        $client->setEmail($form['sender_email']->getData());
        $clientRepo->save($client, true);
        return $client;
    }
    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactRepository $contactRepo, ClientRepository $clientRepo, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $clientRepo->findOneBy(['email' => $form['sender_email']->getData()]);
            $client = $client == null ? $this->createClient($form, $client, $clientRepo) : $client;
            $contact->setClient($client);
            $contactRepo->save($contact, true);
            $this->mail($mailer, $contact->getSenderEmail());
            // $client->addContact($contact);

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
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
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepo, ClientRepository $clientRepo): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepo->save($contact, true);

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepo->remove($contact, true);
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
