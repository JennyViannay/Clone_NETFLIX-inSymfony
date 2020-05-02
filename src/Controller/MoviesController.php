<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MoviesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /* INJECTION DE DEPENDANCE*/
    private $repo;

    public function __construct(MoviesRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('movies/index.html.twig', [
            'popular' => $this->repo->popularFilter(),
            'movies' => $this->repo->homeFilter(1),
            'tvShows' => $this->repo->homeFilter(2),
            'originals' => $this->repo->homeFilter(3)
        ]);
    }

    /**
     * @Route("/show/{id}", name="show-one")
     */
    public function show(Movie $movie): Response
    {
        return $this->render('movies/show.html.twig', ['movie' => $this->repo->find($movie)]);
    }

    /**
     * @Route("/tv-shows", name="tv-shows")
     */
    public function tvShow(): Response
    {
        return $this->render('movies/list.html.twig', ['movies' => $this->repo->findByCategoryField(1)]);
    }

    /**
     * @Route("/movies", name="movies")
     */
    public function movies(): Response
    {
        return $this->render('movies/list.html.twig', ['movies' => $this->repo->findByCategoryField(2)]);
    }

    /**
     * @Route("/originals", name="originals")
     */
    public function originals(): Response
    {
        return $this->render('movies/list.html.twig', ['movies' => $this->repo->findByCategoryField(3)]);
    }

    /**
     * @Route("/recent", name="recent")
     */
    public function recent(): Response
    {
        return $this->render('movies/list.html.twig', ['movies' => $this->repo->recentlyAdd()]);
    }

    /**
     * @Route("/search", name="search", methods={"POST"})
     */
    public function search(Request $request): Response
    {
        $string = $request->request->all();
        return $this->render('movies/list.html.twig', ['movies' => $this->repo->search($string['search'])]);
    }

    /**
     * @Route("/like", name="like", methods={"POST"})
     */
    public function like(Request $request)
    {
        $id = $request->request->all();
        $movie = $this->repo->find($id['id']);
        $movie->setLikes($movie->getLikes() + 1);

        $user = $this->getUser();
        $user->addLike($movie);   

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($movie);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('show-one', ['id' => $id['id']]);
    }

    /**
     * @Route("/dislike", name="dislike", methods={"POST"})
     */
    public function dislike(Request $request)
    {
        $id = $request->request->all();
        $movie = $this->repo->find($id['id']);
        $movie->setLikes($movie->getLikes() - 1);

        $user = $this->getUser();
        $user->removeLike($movie);   

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($movie);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('profile');
    }
}
