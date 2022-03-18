<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Factory\EspecialidadeFactory;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Base;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends BaseController
{

    public function __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $especialidadeRepository,
        EspecialidadeFactory $factory
    ){
        parent::__construct($especialidadeRepository, $entityManager, $factory);
    }

    /**
     * @param Especialidade $entidadeExistente
     * @param Especialidade $entidadeEnviado
     * @return void
     */
    public function atualizaEntidadeExistente(
        $entidadeExistente,
        $entidadeEnviado
    ){
        $entidadeExistente
            ->setDescricao($entidadeEnviado->getDescricao());
    }
}
