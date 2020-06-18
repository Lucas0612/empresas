<?php

namespace Tests;

use PHPUnit\Framework\TestCase;


class inicioTeste extends TestCase { 
     
    public function setUp(): void
    {
    }

    public function testIndiceMenorQueZero(): void  
    {       
        
        $args = array(
            "pontuacao" => 50,
            "nome_empresa"
        );
        $notas = 9;
        $debitos = 58;

        $this->assertEquals(0, $indice = CalculaIndice($args, $notas, $debitos));

    }

    public function testIndiceMaiorQueCem(): void
    {       

        $args = array(
            "pontuacao" => 50,
            "nome_empresa"
        );
        $notas = 50;
        $debitos = 0;
        $this->assertEquals(100, CalculaIndice($args, $notas, $debitos));
    }

    // assertLessThanOrEqual

    public function testIndice41PorCento(): void
    {
        
        $args = array(
            "pontuacao" => 50,
            "nome_empresa"
        );
        $notas = 8;
        $debitos = 9;
        $this->assertEquals(41, $indice =  CalculaIndice($args, $notas, $debitos));

    } 


 }

