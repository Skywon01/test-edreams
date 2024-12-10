<?php

namespace App\Controller;

use App\Entity\Tache;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TacheController extends AbstractController
{
    /**
     * READ
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * Récupère les tâches
     */
    #[Route('/taches', methods: ['GET'])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $taches = $em->getRepository(Tache::class)->findAll();

        return $this->json($taches);
    }

    /**
     * READ
     * @param Tache $tache
     * @return JsonResponse
     * Récupère une tâche
     */
    #[Route('/taches/{id}', methods: ['GET'])]
    public function show(Tache $tache): JsonResponse
    {
        return $this->json($tache);
    }

    /**
     * CREATE
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * Enregistre une tâche
     */
    #[Route('/taches', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $tache = new Tache();

        $tache->setTitre($data['titre']);
        $tache->setDescription($data['description'] ?? null);
        $tache->setStatut($data['statut']);
        $tache->setCreatedAtValue();
        $tache->setUpdatedAtValue();


        $em->persist($tache);
        $em->flush();

        return $this->json($tache, 201);
    }

    /**
     * UPDATE
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @return JsonResponse
     * Modifie une tâche
     */
    #[Route('/taches/{id}', methods: ['PUT'])]
public function update(Request $request, EntityManagerInterface $em, $id): JsonResponse
    {
        $tache = $em->getRepository(Tache::class)->find($id);
        if (!$tache) {
            throw $this->createNotFoundException();
        }
        $data = json_decode($request->getContent(), true);

        if (isset($data['titre'])) {
            $tache->setTitre($data['titre']);
        }
        if (isset($data['description'])) {
            $tache->setDescription($data['description']);
        }
        if (isset($data['statut'])) {
            $tache->setStatut($data['statut']);
        }
        $tache->setUpdatedAtValue();
        $em->persist($tache);
        $em->flush();
        return $this->json($tache);
    }

    /**
     * DELETE
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @return JsonResponse
     * Supprime une tâche
     */
    #[Route('/taches/{id}', methods: ['DELETE'])]
    public function delete(Request $request, EntityManagerInterface $em, $id): JsonResponse
    {
        $tache = $em->getRepository(Tache::class)->find($id);
        if (!$tache) {
            throw $this->createNotFoundException();
        }
        $em->remove($tache);
        $em->flush();
        return $this->json(null, 204);
    }

}
