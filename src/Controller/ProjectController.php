<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/project')]
class ProjectController extends AbstractController
{
    private $entityManager;
    private $projectRepository;

    public function __construct(EntityManagerInterface $entityManager, ProjectRepository $projectRepository)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $projectRepository;
    }

    #[Route('/', name: 'project_index', methods: ['GET'])]
    public function index(): Response
    {
        $projects = $this->projectRepository->findAll();

        return $this->json($projects);
    }

    #[Route('/create', name: 'project_create', methods: ['POST'])]
    public function create(Request $request, ProjectRepository $projectRepository, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);

        $project = new Project();
        $project->setId($projectRepository->generateUniqueId());
        $project->setName($data['name']);
        $project->setLocation($data['location']);
        $project->setStage($data['stage']);
        $project->setCategory($data['category']);
        $project->setConstructionStartDate(new \DateTime($data['constructionStartDate']));
        $project->setDescription($data['description'] ?? null);
        $project->setCreatorId($data['creatorId']);

        $errors = $validator->validate($project);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return $this->json($errorMessages, Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $this->json($project, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'project_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $project = $this->projectRepository->find($id);

        if (!$project) {
            return $this->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($project);
    }

    /**
     * @throws \Exception
     */
    #[Route('/{id}/edit', name: 'project_edit', methods: ['PUT'])]
    public function edit(Request $request, int $id, ValidatorInterface $validator): Response
    {
        $project = $this->projectRepository->find($id);

        if (!$project) {
            return $this->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $project->setName($data['name']);
        $project->setLocation($data['location']);
        $project->setStage($data['stage']);
        $project->setCategory($data['category']);
        $project->setConstructionStartDate(new \DateTime($data['constructionStartDate']));
        $project->setDescription($data['description'] ?? null);
        $project->setCreatorId($data['creatorId']);

        $errors = $validator->validate($project);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return $this->json($errorMessages, Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json($project);
    }

    #[Route('/{id}/delete', name: 'project_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $project = $this->projectRepository->find($id);

        if (!$project) {
            return $this->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($project);
        $this->entityManager->flush();

        return $this->json(['message' => 'Project deleted successfully']);
    }
}