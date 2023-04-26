<?php

namespace App\Controller;

use App\Entity\Review;
use App\Exception\ApiException;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use OpenApi\Annotations as OA;

#[Route('/api', name: 'api')]
class ReviewController extends AbstractController
{
    /**
     * Adds a review to a book.
     *
     * @OA\Post(
     *     path="/add/review",
     *     summary="Add a review to a book",
     *     description="Adds a review to a book with the given ISBN.",
     *     tags={"reviews"},
     * )
     *    @OA\RequestBody(
     *         description="Review data",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="integer", example="4"),
     *             @OA\Property(property="description", type="string", example="This book is amazing!"),
     *             @OA\Property(property="author", type="string", example="John Doe"),
     *             @OA\Property(property="ISBN", type="string", example="9780132350884"),
     *         )
     *     )
     *   @OA\Response(
     *         response=201,
     *         description="Review added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Review added successfully")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad request, missing parameters or invalid ISBN")
     *  @OA\Tag(name="reviews")
     */
    #[Route('/add/review', name: 'app_review_add', methods: ['POST'])]
    public function add(Request $request,  EntityManagerInterface $entityManager, SerializerInterface $serializer, BookRepository $bookRepo): Response
    {
        $data = json_decode($request->getContent(), true);
        if($data['rating']&& $data['description']&& $this->getUser()&& $data['author']&& $data['ISBN']){
            if (!empty($bookRepo->findByISBNField($data['ISBN']))) {
                $book = $bookRepo->findByISBNField($data['ISBN'])[0];
                $review= new Review();
                $review->setRating($data['rating']);
                $review->setDescription($data['description']);
                $review->setAuthor($data['author']);
                $book->addReview($review);
                $entityManager->persist($review);
                $entityManager->flush();
                return $this->json(['message' => 'Review added successfully'], Response::HTTP_CREATED);

            } else {
                throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, "There's no book with provided ISBN");
            }
        }
        else {
            throw new ApiException(JsonResponse::HTTP_BAD_REQUEST, 'Request is incomplete');
        }
    }
}
