<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Factory\MedicoFactory;
use App\Repository\MedicosRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        MedicoFactory $medicoFactory,
        MedicosRepository $medicosRepository
    ){
        parent::__construct($medicosRepository, $entityManager, $medicoFactory);
    }

    /**
     * @param Medico $entidadeExistente
     * @param Medico $entidadeEnviado
     * @return void
     */
    public function atualizaEntidadeExistente($entidadeExistente, $entidadeEnviado)
    {
        $entidadeExistente
            ->setCrm($entidadeEnviado->getCrm())
            ->setNome($entidadeEnviado->getNome())
            ->setEspecialidade($entidadeEnviado->getEspecialidade());
    }

    /**
     * @Route ("/medicos/especialidade/{especialidadeId}", methods={"GET"})
     */
    public function buscaPorEspecialidade(int $especialidadeId): Response
    {
        $medicos = $this->repository->findBy(['especialidade' => $especialidadeId]);
        return new JsonResponse($medicos);
    }
}