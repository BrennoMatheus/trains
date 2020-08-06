Trains

  Solução para o problema 1:

Implementação

  O problema foi resolvido com PHP 7.4, utilizando PHPUnit para realização dos testes automatizados.

  Foram identificadas 3 entidades que fazem parte do domínio do problema:
    - Rotas
    - Cidade
    - Rota
    
    Onde a entidade Rotas possui o conjunto entidades do tipo Cidade (A,B,C,D,E), e cada Cidade possui um conjunto de entidades do tipo Rota com as informações de destino e distância da rota.

    Essas entidades combinadas formam um grafo direcionado que é usado para responder as questões do problema

  A arquitetura do projeto consiste em 4 camadas:
    - Domain: camada principal que contém as interfaces com os casos de uso utilizados pelo programa bem como as entidades e seus comportamentos
    - Data: contém as implementações dos casos de uso
    - Presentation: possui o controlador que recebe o input num formato genérico, realiza a validação dos dados e chama os casos de uso que realizam a lógica da aplicação
    - Main: camada que realiza a composição dos objetos que serão utilizados e contém os adaptadores para entrada e saída de dados

    Para permitir o desacoplamento, facilitar manutenção e permitir escalabilidade foram realizadas as inversões de todas as dependências

    Para testar a integração entre os componentes foram utilizadas injeções de dependências para ser possível mockar e testar se os métodos corretos foram chamados com os parametros certos

    O uso de adaptadores visa permitir que a aplicação seja independente de frameworks ou tipos de entradas e saídas diferentes. Caso fosse necessário utilizar arquivos para realizar IO, ou se fosse uma requisição http, bastaria escrever um adaptador para a interface que o controlador espera receber
    
  O fluxo de execução do programa se dá da seguinte forma:
    - recebe um input da entrada padrão (console)
    - adapta o input para um formato genérico que a camada de apresentação espera receber
    - realiza a validação dos dados contidos no input
    - chama a implementação de um caso de uso (interface) que tem como objetivo montar as rotas passadas no input e retornar as informações que o problema pede
    - retorna as informações processadas num formato genérico
    - adapta os dados retornados para o formato desejado (nesse caso saída padrão)


Para executar o programa
  requisitos:
    - docker
    - composer

  abra o terminal na raiz do projeto e digite:
  - composer install
  - docker build -t trains .
  - docker run -it trains

  - insira um caso de teste


CASOS DE TESTE

  input:
    AB5, BC4, CD8, DC8, DE6, AD5, CE2, EB3, AE7

  output:
    Output #1: 9
    Output #2: 5
    Output #3: 13
    Output #4: 22
    Output #5: NO SOUCH ROUTE
    Output #6: 2
    Output #7: 3
    Output #8: 9
    Output #9: 9
    Output #10: 7

  input:
    AB8, AC8, BE7, BC100, CA8, CB111, DA20, DB30, DC5, DE40, EB7, EA50

  output:
    Output #1: 108
    Output #2: NO SOUCH ROUTE
    Output #3: NO SOUCH ROUTE
    Output #4: NO SOUCH ROUTE
    Output #5: NO SOUCH ROUTE
    Output #6: 3
    Output #7: 5
    Output #8: 8
    Output #9: 14
    Output #10: 1
