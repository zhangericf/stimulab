<?php

namespace App\Controller;

use App\Repository\DiscussionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class DiscussionController extends AbstractFOSRestController
{
    private $discussionRepository;

    public function __construct(DiscussionRepository $discussionRepository)
    {
        $this->discussionRepository = $discussionRepository;
    }

    /**
     * @Route("/add", name="add_discussion", methods="POST")
     */
    public function addDiscussion(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $theme = $data['theme'];
        $state = $data['state'];
        $message = $data['message'];

        if (empty($username) || empty($theme) || empty($state) || empty($message)) {
            throw new NotFoundHttpException("Expecting more arguments");
        }

        $this->discussionRepository->saveDiscussion($username, $theme, $state, $message);

        return new JsonResponse(['status' => 'Discussion created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/getDiscussions", name="get_discussions", methods="GET")
     */
    public function getDiscussions(): JsonResponse
    {
        $discussions = $this->discussionRepository->findAll();

        $discussions = $this->discussionRepository->transformArray($discussions);

        return new JsonResponse($discussions);
    }
}
