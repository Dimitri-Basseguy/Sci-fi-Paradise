<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * Ajout du Bundle Flashy
     */
    public function __construct(FlashyNotifier $flashy)
    {
        $this->flashy = $flashy;
    }

    /**
     * @Route("/", name="book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="book_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $path = $this->getParameter('kernel.project_dir').'/public/assets/img/cover';
            $cover = $book->getCover();
            $file = $cover->getFile();
            $book->setScore(0);
            $coverName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($path, $coverName);
            $cover->setName($coverName);
            $book->addUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            $this->flashy->success('Livre créé');

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/plus", name="plus")
     */
    public function votePlus(Book $book)
    {
        $book->setScore($book->getScore() + 1);
        $this->getDoctrine()->getManager()->flush();
        $this->flashy->success('Vote + validé');

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route("/{id}/moins", name="moins")
     */
    public function voteMoins(Book $book)
    {
        $book->setScore($book->getScore() - 1);
        $this->getDoctrine()->getManager()->flush();
        $this->flashy->success('Vote - validé');

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route("/{id}", name="book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->flashy->success('Livre modifié');

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();

        }
        $this->flashy->success('Livre supprimé');
        return $this->redirectToRoute('book_index');
    }
}
