<?php
/**
 * Classe para calculo de notas e tratamento dos valores para retornar a menor 
 * quantida de notas para o valor solicitado
 */
class Calculo {
    
    /**
     *
     * @var array Notas disponiveis para retirada
     */
    var $notas = array(
        0 => 100,
        1 => 50,
        2 => 20,
        3 => 10
    );
    
    /**
     *
     * @var array Totais de notas de cada tipo calculadas para o valor 
     */
    var $resultado = array();
    
    /**
     *
     * @var boolean Flag para validação de valores 
     */
    var $valido = true;
    
    /**
     * Validador de valor, para não necessitar testar a disponibilidade de 
     * notas e verificar que o valor não é valido
     * @param string $valor Valor solicitado para retirada
     * @return array Retorno da validação do valor
     */
    function validarValor($valor) {
        if (is_null($valor)) {
            $data['erro'] = '[Empty Set]';
        } else if (is_numeric($valor)) {
            if ($valor > 0) {
                $data['erro'] = null;
            } else {
                $data['erro'] = 'throw InvalidArgumentException';
            }
        } else {
            $data['erro'] = 'throw InvalidValue';
        }
        return $data;
    }
    
    /**
     * Calcula a quantidade de cada tipo de nota e retorna a quantidade de cada 
     * tipo para retornar a menor quantida de notas para o valor solicitado
     * @param string $valor Valor a ser calculado já validade
     * @param integer $nota Indice da nota a ser calculada
     * @return string Texto formatado para exibição
     */
    function calcularNotas($valor, $nota) {
        $countNotas = floor($valor / $this->notas[$nota]);
        $restoNotas = $valor % $this->notas[$nota];
        $this->resultado[$nota] = $countNotas;
        $totalNotas = count($this->notas);
        if ($totalNotas > $nota + 1 && $restoNotas > 0) {
            $this->calcularNotas($restoNotas, $nota + 1);
        } else if ($totalNotas <= $nota + 1 && $restoNotas > 0) {
            $this->valido = false;
        }
        if ($this->valido) {
            return $this->tratarResultado();
        } else {
            return 'throw NoteUnavailableException';
        }
    }
    
    /**
     * Trata o resultado transformando o array em texto conforme o padrão 
     * definido na solicitação
     * @return string Texto formatado para exibição
     */
    function tratarResultado() {
        if (is_array($this->resultado)) {
            $resultado = '[';
            foreach ($this->resultado as $indice => $quantidade) {
                if ($quantidade > 0) {
                    for ($i = 0; $i < $quantidade; $i++) {
                        $resultado .= $this->notas[$indice] . '.00, ';
                    }
                }
            }
            return substr($resultado, 0, -2) . ']';
        } else {
            return 'throw InvalidValue';
        }
    }
}
?>
