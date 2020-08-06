<?php

namespace App\Main\Adapters;

use App\Main\Factories\GetRoutesInfoControllerFactory;
use App\Presentation\Protocols\Request;

class STDIOAdapter
{
    public function run()
    {
        echo "Para sair digite 'quit'\n";
        echo "Digite as rotas dos trens:\n";

        while (true) {
            $input = trim(fgets(STDIN));

            if ($input === 'quit') die;

            $inputs = preg_split("/, /", $input);

            $controller = (new GetRoutesInfoControllerFactory())->make();
            $response = $controller->handle(new Request($inputs));

            if ($response->getStatusCode() === 200)
                foreach ($response->getBody() as $key => $value) {
                    $key = ++$key;
                    $value = $value ?? 'NO SOUCH ROUTE';
                    $value = $value === 999999 ? 'NO SOUCH ROUTE' : $value;
                    echo "Output #$key: $value\n";
                }
            else
                echo "Houve erro ao executar o programa, tente novamente \n";

            echo "Digite as rotas dos trens: \n";
        }
    }
}

//AB8, AC8, BE7, BC100, CA8, CB111, DA20, DB30, DC5, DE40, EB7, EA50
