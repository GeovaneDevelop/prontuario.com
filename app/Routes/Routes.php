<?php

namespace App\Routes;

use \Klein\Klein;

class Routes {

    private $klein;
    private $twig;

    public function __construct() {
        $this->klein = new Klein();
        $this->twig = new Twig();
        session_start();
    }

    public function start(){

        /*Login e autenticação*/
        $login = new \App\Routes\account\Login($this->klein, $this->twig);
        $login->start();

        /*Home da aplicação*/
        $core = new \App\Routes\core\Core($this->klein, $this->twig);
        $core->start();
        $core->error();

        $core = new \App\Routes\medico\Medico($this->klein, $this->twig);
        $core->start();

        $core = new \App\Routes\paciente\Paciente($this->klein, $this->twig);
        $core->start();

        $core = new \App\Routes\agendamento\Agendamento($this->klein, $this->twig);
        $core->start();

        $core = new \App\Routes\atendimento\Atendimento($this->klein, $this->twig);
        $core->start();

        $this->klein->dispatch();

    }

}
