<?php 

namespace App\Controllers\core;

class Endereco{

    private $estados;
    private $cidades;
    private $paises;

    public function __construct(){
        $endereco = new \App\Models\core\Endereco();
        $this->estados = $endereco->getEstados();
        $this->cidades = $endereco->getCidades();
        $this->paises = $endereco->getPais();                
    }

    public function getEstados(){
        if ($this->estados['status'] == 200){
            return $this->estados['resultado'];
        }else{
            return "error";
        }
    }
    
    public function getCidades(){
        if ($this->cidades['status'] == 200){
            return $this->cidades['resultado'];
        }else{
            return "error";
        }
    }

    public function getPais(){
        if ($this->paises['status'] == 200){
            return $this->paises['resultado'];
        }else{
            return "error";
        }
    }

}