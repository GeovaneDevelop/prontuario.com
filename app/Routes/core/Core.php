<?php

namespace App\Routes\core;


class Core{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }

    public function start(){

        $this->klein->respond('/', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true or $_SESSION['statusMed'] == true){
            
                    echo $this->twig->getTwig()->render('core/index.html', array(
                    "user" => $_SESSION,
                ));
            }else{
                $response->redirect('/login');
            }

        });

        $this->klein->respond('GET', '/te', function ($request, $response, $service) {
            if ($_SESSION['status'] == true){
                $medicoList = new \App\Controllers\medico\MedicoList();
                $medicos = $medicoList->getMedicos();
                $arr1 = str_split(strtolower($_GET["q"]));
                $pattern = '/' . strtolower($_GET["q"]). '/';
                $medico = $medicos[1];

                $resultado = [];
                $status;
                $i = 0;

                foreach ($medicos as $medico){
                    if (preg_match($pattern, strtolower($medico["nome"]))) {
                        $resultado[$i] = $medico;
                        $i++;
                    }
                }
                foreach ($resultado as $medico){
                    echo $this->twig->getTwig()->render('core/tabela.html', array(
                        "medico" => $medico
                    ));
                }
            }else{
                $response->redirect('/login');
            }
        });

        $this->klein->respond('GET', '/medicos/te', function ($request, $response, $service) {
            if ($_SESSION['status'] == true){
                $en = new \App\Models\core\Endereco();
                $cidade = $en->getCidades()['resultado'];
                foreach ($cidade as $city){
                    if($city["Uf"] == $_GET["dados"]){
                        echo "<option  value=".$city["Nome"].">" . $city['Nome'] ."</option>";
                    }
                }
            }else{
                $response->redirect('/login');
            }

        });
    }

    public function error(){

        $this->klein->onHttpError(function($code, $router) {
            switch($code) {
                case 404:
                    $router->response()->body(
                        $this->twig->getTwig()->render('/core/error.html', array(
                            "code" => $code
                        ))
                    );
                    break;
                default:
                    $router->response()->body(
                        $this->twig->getTwig()->render('/core/error.html', array(
                            "code" => $code
                        ))
                    );
            }
        });
    }
}
