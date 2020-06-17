<?php

namespace Tests;

use App\importar;
use PHPUnit\Framework\TestCase;

 class inicioTeste extends TestCase {   
    

    public function Setup()
    {
        
    }

    public function TestaIndiceMenorQueZero(): void    
    {
        $args = array(
            "pontuacao" => 50,
            "nome_empresa"
        );
        $notas = 9;
        $debitos = 58;

        $this->assertEquals(0, $indice = CalculaIndice($args, $notas, $debitos));

    }

    public function TestarIndiceMaiorQueCem(): void
    {
        $args = array(
            "pontuacao" => 50,
            "nome_empresa"
        );
        $notas = 50;
        $debitos = 0;
        $this->assertEquals(100, $indice = CalculaIndice($args, $notas, $debitos));
    }

    // assertLessThanOrEqual

    public function TestarIndice(): void
    {
        $args = array(
            "pontuacao" => 50,
            "nome_empresa"
        );
        $notas = 8;
        $debitos = 9;
        $this->assertEquals(41, $indice = CalculaIndice($args, $notas, $debitos));

    } 


 }

