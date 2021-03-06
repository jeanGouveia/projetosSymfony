<?php

namespace App\Factory;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory implements EntidadeFactory
{
    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {

        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarEntidade(string $json): Medico
    {
        $dadoEmJson = json_decode($json);
        $especialidadeID = $dadoEmJson->especialidadeId;
        $especialidade = $this->especialidadeRepository->find($especialidadeID);

        $medico = new Medico();
        $medico
            ->setCrm($dadoEmJson->crm)
            ->setNome($dadoEmJson->nome)
            ->setEspecialidade($especialidade);

        return $medico;
    }

}