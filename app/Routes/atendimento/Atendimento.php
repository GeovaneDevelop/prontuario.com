<?php

namespace App\Routes\atendimento;

class Atendimento{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }

    public function start(){


        $this->klein->respond('GET', '/atendimento', function ($request, $response, $service) {
            $list = new \App\Controllers\agendamento\AgendamentoList();
            
            if (!$_GET){
                $_GET['id'] = 'not';
            }

            if ($_SESSION['statusMed'] == true){
                    echo $this->twig->getTwig()->render('atendimento/atendimento.html', array(
                    "user" => $_SESSION,
                    "get" => $_GET['id'],
                ));
            }else{
                $response->redirect('/login');
            }

        });

        $this->klein->respond('GET', '/timeline', function ($request, $response, $service) {

            $co = new \App\Controllers\atendimento\AtendimentoList();

            if ($_SESSION['statusMed'] == true){
                    echo $this->twig->getTwig()->render('atendimento/timeline.html', array(
                    "user" => $_SESSION,
                    "atendimentos" => $co->getAtendimentos($_GET['id'])    
                ));
            }else{
                $response->redirect('/login');
            }

        });

        
        $this->klein->respond('POST', '/atendimento', function ($request, $response, $service) {
            
            $con = new \App\Controllers\atendimento\Atendimento($_POST);
            
            if($con->Validacao()){
                echo $this->twig->getTwig()->render('atendimento/atendimento.html', array(
                    "user" => $_SESSION,
                    "erros" => $con->Validacao(),
                    "form" => $_POST,
                    "get" => $_POST['codigo_agendamento']
                ));
            }else{
                $con->insertAtendimento();
                $response->redirect('/agendados');
            }    
        });


    }
}