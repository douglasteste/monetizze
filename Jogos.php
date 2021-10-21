<?php

class Jogos {
    
    private int $quantidade_dezenas;
    private array $resultado;
    private array $total_jogos;
    private array $jogos = [];
    private string $mensagem_erro = '<b style="color: red">Erro Encontrado: </b>';

    public function __construct($quantidade_dezenas, $total_jogos) { 
        if ($quantidade_dezenas > 5 && $quantidade_dezenas <= 10) {
            $this->quantidade_dezenas = $quantidade_dezenas;
        } else {
            echo $this->mensagem_erro . ' É necessário informar um valor entre 6 e 10. <br><br> Valor informado: <span style="color: red">' . $quantidade_dezenas . '</span>';
            return FALSE;
        }

        if (is_array($total_jogos)) {
            $this->total_jogos = $total_jogos;
        } else {
            echo $this->mensagem_erro . ' É necessário informar um valor do tipo Array. <br><br> Tipo informado: <span style="color: red">' . gettype($quantidade_dezenas) . '</span>';
            return FALSE;
        }
        
    }

    public function set($quantidade_dezenas, $resultado, $total_jogos, $jogos) {
        $this->quantidade_dezenas = $quantidade_dezenas;
        $this->resultado = $resultado;
        $this->total_jogos = $total_jogos;
        $this->jogos = $jogos;
    }

    public function get() {
        $array_retornada = [
            'quantidade_dezenas' => $this->quantidade_dezenas,
            'resultado' => $this->resultado,
            'total_jogos' => $this->total_jogos,
            'jogos' => $this->jogos
        ];
        return $array_retornada;
    }

    private function gerarArrayDezenas() {
        $limites = range(10,60);
        shuffle($limites);
        $array_retornada = array_slice($limites, 0, $this->quantidade_dezenas);
        array_multisort($array_retornada);
        return $array_retornada;
    }

    public function gerarArrayJogos() {
        $array_jogos = [];
        for ($i=0; $i < count($this->total_jogos); $i++) {
            $array_jogos[$this->total_jogos[$i]] = $this->gerarArrayDezenas();
        }
        $this->jogos = $array_jogos;
    }

    public function gerarResultado() {
        $limites = range(10,60);
        shuffle($limites);
        $array_retornada = array_slice($limites, 0, 6);
        array_multisort($array_retornada);
        $this->resultado = $array_retornada;
    }

    public function gerarJogos() {
        $retorno_html = '<table style="width: 70%; margin: 1% auto; text-align: center; font-size: 14px">
                        <thead style="color: red; font-weight: bold">
                            <tr>
                                <th>Jogos</th>
                                <th>Quantidade de Dezenas Sorteadas</th>
                            </tr>
                        </thead>
                        <tbody>';
        $this->gerarArrayJogos();
        $this->gerarResultado();
        foreach ($this->jogos as $jogo => $resultado) {
            $retorno_html .= "<tr>
                                <td>". json_encode($resultado) ."</td>
                                <td>". $this->quantidade_dezenas ."</td>
                            </tr>";
        }
        $retorno_html .= "</tbody>
                        </table>";
        return $retorno_html;
    }

}
