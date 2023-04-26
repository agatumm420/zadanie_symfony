<?php

namespace App\Controller;

use App\Entity\Book;
use App\Exception\ApiException;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Pagerfanta\Adapter\ArrayAdapter;
use Doctrine\ORM\Query;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use OpenApi\Annotations as OA;
use App\UserDto;
use App\BookResponse;
use App\BookRequest;
use App\DeleteRequest;
use App\AllBooksResponse;
#[Route('/api', name: 'api')]
class BookController extends AbstractController
{
    /**
     * Returns user's books.
     *
     * Availible only to logged in users.
     *

     * @OA\Response(
     *     response=200,
     *     description="Returns user's books",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=BookResponse::class ))
     *     )
     * )


     * @OA\Tag(name="books")
     *
     */
    #[Route('/book', name: 'app_book', methods: ['GET'])]
    public function index(Request $request, SerializerInterface $serializer): Response
    {
        $user = $this->getUser();
        $books = $user->getBooks();

        $serializedBooks = $serializer->serialize($books, 'json', ['groups' => 'book']);
        if(!$this->getUser()){
            throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'You have to be logged in ');
        }
        return new JsonResponse($serializedBooks, JsonResponse::HTTP_OK, [], true);
    }
    /**
     * Let s user add another one of his/hers books .
     *
     * Availible only to logged in users.
     *

     * @OA\Response(
     *     response=200,
     *     description="Returns user's books",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=BookResponse::class ))
     *     )
     * )
     * @OA\Response(response=400, description="Request is incomplete or ISBN is not correct", )
     * @OA\RequestBody(@Model(type=BookRequest::class))
     * @OA\Tag(name="books")
     *
     */
    #[Route('/book/add', name: 'app_book_add', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, BookRepository $bookRepo): Response
    {
        $data = json_decode($request->getContent(), true);

        if (array_key_exists('title', $data)&& $this->getUser() &&array_key_exists('description', $data)&& array_key_exists('ISBN', $data)) {
            if(13 >= $data['ISBN'] && $data['ISBN'] >= 4) {


                if ($bookRepo->findByISBNField($data['ISBN'])) {
                    throw new ApiException(JsonResponse::HTTP_CONFLICT, "The book already exists");
                }

                $book = new Book();
                $book->setTitle($data['title']);
                $book->setAuthor($this->getUser());
                $book->setDescription($data['description']);
                $book->setISBN($data['ISBN']);
                $entityManager->persist($book);
                $entityManager->flush();


                $serializedBook = $serializer->serialize($book, 'json', ['groups' => 'book']);
                $responseData = json_decode($serializedBook, true);

                return $this->json(['book' => $responseData]);
            }
            else{
                throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'ISBN is not correct');
            }
        } else {
            throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'Request is incomplete');
        }
    }
    /**
     * Let s user update his/hers book.
     *
     * The only neccesary property that that has to be included in the request is ISBN.
     *

     * @OA\Response(
     *     response=200,
     *     description="Returns the updated book",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Property(
     *            property="book",
     *            ref=@Model(type=Book::class, groups={"book"})
     *        )
     *     )
     * )
     * @OA\Response(response=400,description="You need to provide ISBN",)
     *  @OA\Response(response=401,description="It's not your book",)
     * @OA\RequestBody(@Model(type=BookRequest::class))
     * @OA\Tag(name="books")
     *
     */
    #[Route('/book/update', name: 'app_book_update', methods: ['POST'])]
    public function update(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer,BookRepository $bookRepo): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($bookRepo->findByISBNField($data['ISBN']))) {
            $book = $bookRepo->findByISBNField($data['ISBN']);
            $user = $this->getUser();
            if($user->hasBook($book)){
                array_key_exists('title', $data)?$book->setTitle($data['title']):null;

                array_key_exists('description', $data)?$book->setDescription($data['description']):null;
                // array_key_exists('ISBN', $data)?$book->setISBN($data['ISBN']):null;

                $entityManager->persist($book);
                $entityManager->flush();


                $serializedBook = $serializer->serialize($book, 'json', ['groups' => 'book']);
                $responseData = json_decode($serializedBook, true);

                return $this->json(['book' => $responseData]);
            }
            else{
                throw new ApiException(JsonResponse::HTTP_UNAUTHORIZED,"It's not your book");
            }

        } else {
            throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'You need to provide ISBN');
        }
    }
    /**
     * Let's user delete his/hers book.
     *
     * The only neccesary property that that has to be included in the request is ISBN.
     *

     *  @OA\Response(response=200,description="",)
     *
     *
     *  @OA\Response(response=400,description="You need to provide ISBN",)
     *  @OA\Response(response=401, description="It's not your book",)
     * @OA\RequestBody(@Model(type=DeleteRequest::class))

     * @OA\Tag(name="books")
     *
     */
    #[Route('/book/delete', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer,BookRepository $bookRepo): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($bookRepo->findByISBNField($data['ISBN']))) {
            $book = $bookRepo->findByISBNField($data['ISBN']);
            $user = $this->getUser();

            if($user->hasBook($book)){
                $entityManager->remove($book);
                $entityManager->flush();
                return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
            }
            else{
                throw new ApiException(JsonResponse::HTTP_UNAUTHORIZED, "It's not your book");
            }



        } else {
            throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'You need to provide ISBN');
        }
    }
    /**
     * Shows user all of the books.
     *
     * You can input page number, title, description in the request adress.
     *

     * @OA\Response(
     *     response=200,
     *     description="Returns user's books",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=BookResponse::class ))
     *     )
     * )

     * @OA\RequestBody(@Model(type=AllBooksResponse::class))
     * @OA\Tag(name="books")
     *
     */
    #[Route('/book/list/all/page/{page}', name: 'app_book_list_all', methods: ['GET'])]

    public function list_all(Request $request,$page,  EntityManagerInterface $entityManager, SerializerInterface $serializer,BookRepository $bookRepo): Response
    {
        $title = $request->query->get('title');
        $desc = $request->query->get('desc');
        $queryBuilder = $bookRepo->createQueryBuilder('e')
            ->orderBy('e.createdAt', 'DESC');
        if($title){
            $queryBuilder = $bookRepo->createQueryBuilder('e')
                ->where('e.title = :title')
                ->setParameter('title', $title)
                ->orderBy('e.createdAt', 'DESC');
            if($desc)
            {
                $queryBuilder = $bookRepo->createQueryBuilder('e')
                    ->where('e.title = :title')
                    ->setParameter('title', $title)
                    ->andWhere('e.description = :description')
                    ->setParameter('description', $desc)
                    ->orderBy('e.createdAt', 'DESC');
            }
        }
        if($desc && !$title)
        {
            $queryBuilder = $bookRepo->createQueryBuilder('e')

                ->where('e.description = :description')
                ->setParameter('description', $desc)
                ->orderBy('e.createdAt', 'DESC');
        }


        $results = $queryBuilder->getQuery()->getResult(Query::HYDRATE_ARRAY);
        $adapter = new ArrayAdapter($results );
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
        return  $this->json(['page'.$page.''=>$pagerfanta->getCurrentPageResults()]);
    }
}
