<?php

namespace App\Controller;

use App\Factory\EntidadeFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    /**
     * @var ObjectRepository
     */
    protected ObjectRepository $repository;
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;
    /**
     * @var EntidadeFactory
     */
    protected $factory;

    public function __construct(
        ObjectRepository $repository,
        EntityManagerInterface $entityManager,
        EntidadeFactory $factory
    ){
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
    }

    public function novo(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $entidade = $this->factory->criarEntidade($dadosRequest);
        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        return new JsonResponse($entidade);
    }

    public function buscarTodos(): Response
    {
        $entityList = $this->repository->findAll();
        return new JsonResponse($entityList);
    }

    public function buscarUm(int $id): Response
    {
        return new JsonResponse($this->repository->find($id));
    }

    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $entidadeEnviado  = $this->factory->criarEntidade($corpoRequisicao);

        $entidadeExistente = $this->repository->find($id);

        if(is_null($entidadeExistente))
        {
            return new Response('', Response::HTTP_NOT_FOUND);
        }else
        {
            $status = 200;
        }

        $this->atualizaEntidadeExistente($entidadeExistente, $entidadeEnviado);


        $this->entityManager->flush();

        return new JsonResponse($entidadeExistente, $status);
    }

    public function remove(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();
        return new Response('Exclusão efetuada com sucesso!', Response::HTTP_NO_CONTENT);
    }

    abstract public function atualizaEntidadeExistente(
        $entidadeExistente, $entidadeEnviado
    );


}