<?php
  /**
   * Retorna a string html de options dos registros para um select
   *
   * @param [] $aArray
   * @param [] $aSelecionados
   * @param [] $aAtributos
   * @param [] $aGroups
   *
   * @return string
   */
  function fOption($aArray, $aSelecionados = NULL, $aAtributos = NULL, $aGroups = [], $aClasses = NULL) {

    $sTag = '<option class="%s" %s %s value="%s" %s %s>%s</option>';
    $sTagGroup = '<optgroup label="%s">%s</optgroup>';

    if(is_array($aSelecionados)){
      $aSelecionados = array_map('strval', $aSelecionados);
    }

    $aOptions = array();

    foreach ($aArray as $sItem => $sValor) {

      $sSelected = '';

      if(is_array($aSelecionados)){
        if(in_array((string) $sItem, $aSelecionados)){
          $sSelected = 'selected="selected"';
        }
      } elseif(!is_null($aSelecionados)){
        if((string) $sItem == (string) $aSelecionados){
          $sSelected = 'selected="selected"';
        }
      }

      $sOption = sprintf(
        $sTag
        , $aClasses[$sItem]
        , (($sValor == 'Sem Marcador de Estrutura Mercadológica') ? 'data-produto="SM_EST"' : '')
        , (($sValor == 'Sem Marcador de Produtos') ? 'data-produto="SM_PRO"' : '')
        , $sItem
        , $sSelected
        , $aAtributos[$sItem]
        , $sValor
      );
      if(!empty($aGroups)) {
        $aOptions[$aGroups[$sItem]][] = $sOption;
      } else {
        $aOptions[] = $sOption;
      }
    }

    $aOptionGroup = [];
    if(!empty($aGroups)) {
      foreach($aGroups as $sValor => $sDescricao) {
        if(!isset($aOptionGroup[$sDescricao])) {
          $aOptionGroup[$sDescricao] = sprintf(
            $sTagGroup
            , $sDescricao
            , implode($aOptions[$sDescricao])
          );
        }
      }
    }

    return (empty($aOptionGroup)) ? implode($aOptions) : implode($aOptionGroup);
  }

  /**
   * Função que retorna uma string sem espaço nas laterais e
   * caso passado parametro true tira os espaços duplos
   *
   * @param [type] $string
   * @param boolean $removeEspacosDuplos
   * @return void
   */
  function fTrim($string, $removeEspacosDuplos = false) {
    if ($removeEspacosDuplos) {
      return trim(preg_replace('/\s+/', ' ', $string));
    }
    return trim($string);
  }

  /**
   * Função que retorna mb_strtoupper
   *
   * @param [type] $string
   * @return void
   */
  function fUpper($string) {
    return mb_strtoupper($string, 'UTF-8');
  }

  /**
   * Função que retorna mb_strtolower
   *
   * @param [type] $string
   * @return void
   */
  function fLower($string) {
    return mb_strtolower($string, 'UTF-8');
  }

  /**
   * Formata para o formato cnpj
   *
   * @param [type] $campo
   * @return void
   */
  function fFormatarCNPJ($campo) {
    $campo = fDado($campo);
    //retira formato
    $codigoLimpo = fLpad(fRetira($campo, 'L'), 14, 0);
    //$codigoLimpo = fRetira($campo,'L');
    // seleciona a máscara para cpf ou cnpj
    $mascara = '##.###.###/####-##';

    $indice = -1;
    for ($i = 0; $i < strlen($mascara); $i++) {
      if ($mascara[$i] == '#')
        $mascara[$i] = $codigoLimpo[++$indice];
    }
    //retorna o campo formatado
    return $mascara;
  }

  /**
   * Acrescenta caracteres a esquerda
   *
   * @param [type] $string
   * @param [type] $quantidade
   * @param [type] $conteudo
   * @return string
   */
  function fLpad($string, $quantidade, $conteudo) {
    return str_pad($string, $quantidade, $conteudo, STR_PAD_LEFT);
  }

  /**
   * Acrescenta caracteres a direita
   *
   * @param [type] $string
   * @param [type] $quantidade
   * @param [type] $conteudo
   * @return string
   */
  function fRpad($string, $quantidade, $conteudo) {
    return str_pad($string, $quantidade, $conteudo, STR_PAD_RIGHT);
  }

  /**
   * Retira do valor passado o tipo de arquivo
   * Ex.: Para tirar acentos
   * $str = Feijão;
   * $str = fRetira($str,"A"); //imprime feijao
   *
   * @param [type] $valor
   * @param [type] $tipo
   * @return string
   */
  function fRetira($valor, $tipo) {
    switch ($tipo) {

      case 'L': //Retira Letras
        return preg_replace("/[^0-9]/", "", $valor);
        break;

      case 'N': //Retira Números
        return preg_replace("/[0-9]/", "", $valor);
        break;

      case 'A': //Retira Acentos
        return fRetiraAcentos($valor);
        break;

      case 'E': //Retira somente caracteres especiais
        return preg_replace('/[^A-Za-z0-9\-]/', '', $valor);
        break;

      default:
        return '';
        break;
    }
  }

  /**
   * Remove acentos
   *
   * @param [type] $texto
   * @return void
   */
  function fRetiraAcentos($texto) {
    $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
        , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
    $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
        , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
    return str_replace($array1, $array2, $texto);
  }

  /**
   * Formata para o formato cpf
   *
   * @param [type] $campo
   * @return void
   */
  function fFormatarCPF($campo) {
    //retira formato
    $codigoLimpo = fLpad(fRetira($campo, 'L'), 11, 0);
    //$codigoLimpo = fRetira($campo,'L');
    // seleciona a máscara para cpf ou cnpj
    $mascara = '###.###.###-##';

    $indice = -1;
    for ($i = 0; $i < strlen($mascara); $i++) {
      if ($mascara[$i] == '#')
        $mascara[$i] = $codigoLimpo[++$indice];
    }
    //retorna o campo formatado
    return $mascara;
  }

  /**
   * Formata para o formato cpf
   *
   * @param [type] $campo
   * @return void
   */
  function fFormatarCpfCnpj($campo) {
    if(strlen(fRetira($campo, 'L')) <= 11 && fValidaCpf($campo)) {
      return fFormatarCPF($campo);
    }
    return fFormatarCNPJ($campo);
  }

  /**
   * ValidarCpf
   *
   * @param string $cpf
   * @return boolean
   */
  function fValidaCpf($cpf) {
    $cpf = fDado($cpf);

    $cpf = fLpad(fRetira($cpf, 'L'), 11, 0);
    if (strlen($cpf) > 11 || $cpf == '00000000000') {
      return false;
    }

    $cpf = fLpad(fRetira($cpf, 'L'), 11, 0);

    if (strlen($cpf) != 11 ||
        $cpf == '11111111111' ||
        $cpf == '22222222222' ||
        $cpf == '33333333333' ||
        $cpf == '44444444444' ||
        $cpf == '55555555555' ||
        $cpf == '66666666666' ||
        $cpf == '77777777777' ||
        $cpf == '88888888888' ||
        $cpf == '99999999999') {
      return false;
    }

    for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
        $d += $cpf[$c] * (($t + 1) - $c);
      }

      $d = ((10 * $d) % 11) % 10;

      if ($cpf[$c] != $d) {
        return false;
      }
    }

    return true;
  }

  /**
   * Função que retorna true se o dado for número ou vazio
   *
   * @param mixed $vlr
   * @return void
   */
  function fIsNumeric($vlr) {
    if (!empty($vlr) && !is_numeric($vlr)) {
      return false;
    }
    return true;
  }

  /**
   * Passa o dado e scolha o tipo dele
   *
   * @param [type] $valor
   * @param string $tipo
   * @param string $formato
   * @param string $tipoValor
   * @param boolean $tiraExcessoEspaco
   * @return string
   */
  function fDado($valor, $tipo = 'S', $formato = 'U', $tipoValor = 'G', $tiraExcessoEspaco = true) {

    $valor = (String) $valor;

    $valor_aux = $valor;
    $valor = fTrim($valor, $tiraExcessoEspaco);
    if($valor != '') {

    if (!empty($formato)) {
      if ($formato == 'U') {
        $valor = fUpper($valor);
      } else if ($formato == 'L') {
        $valor = fLower($valor);
      }
    }

    switch ($tipo) {

      case 'CNPJ':
        return fFormatarCNPJ($valor);
        break;

      case 'CPFCNPJ':
        return fFormatarCpfCnpj($valor);
        break;

      case 'D': //Data
        $valor_aux = $valor;
        $valor = fData($valor, $tipoValor);
        //Caso não for uma data válida ele não trará nada, então enviar o que tinha antes do fData
        $valor = empty($valor) ? $valor_aux : $valor;
        break;

      case 'I': //Inteiro
          $valor_aux = $valor;
          $valor = fValor($valor, $tipoValor);
          if(!fIsNumeric($valor)) {
            return $valor_aux;
          } else if(is_float($valor)) {
            return $valor_aux;
          }
        $valor = intval($valor);
        break;

      case 'F': //Float
          $valor_aux = $valor;
          $valor = fValor($valor, $tipoValor);
          $valor = empty($valor) ? $valor_aux : $valor;
        break;

      default:
        break;
      }
    }

    return ($valor == '' ? $valor_aux : $valor);
  }

  /**
   * Muda formato da data (tipo G -> AAAA-MM-DD, tipo M -> DD/MM/AAAA).
   * G de "gravar", M de "mostrar".
   */
  function fData($data, $tipo = "M") {

    $data = fDado($data);

    //25 = Se acontecer isso, ex.: 2015-05-21T12:36:57-03:00
    //23 = 2019-11-27T13:42:12.063
    if((strlen($data) == 25) || (strlen($data) == 23)){
      $data = substr($data, 0,19);
      $data = str_replace('T', ' ', $data);
    }

    if (!empty($data) && ($data != '0000-00-00') && ($data != '00/00/0000')) {
      if (strlen(fRetira($data, 'L')) <= 14) {
        list($data, $hora) = explode(' ', $data);

        list($ano, $mes, $dia) = explode($data[4], $data); // para ' . e - ' Ex.: 2013.01.20;

        if (strpos($data, '/')) {
          list($dia, $mes, $ano) = explode($data[2], $data); //para ' / ' Ex.: 01/01/2013
        }

        if (!empty($hora)) {
          $data_h = substr($hora, strpos($data, " "), 5);
        }

        if ($tipo == "G") {
          if (checkdate($mes, $dia, $ano)) {
            return trim($ano . "-" . $mes . "-" . $dia . ' ' . $data_h);
          } else {
            return null;
          }
        } else if ($tipo == "M") {
          return trim($dia . "/" . $mes . "/" . $ano . ' ' . $data_h);
        }
      }
    } else {
      if ($tipo == 'M') {
        return '';
      } else {
        return null;
      }
    }
  }

  function fHora($data, $tipo = "M") {
    /* MUDA FORMATO DA DATA
      TIPO G = FORMATA PARA GRAVAR AAAA/MM/DD
      TIPO M = FORMATA PARA MOSTRAR  DD/MM/AAAA
    */
    if (!empty($data)) {
      if ($tipo == "G") {
        return $data;
      } else
      if ($tipo == "M") {
        return date('H:i', strtotime($data));
      }
    } else {
      return null;
    }
  }

  function fValor($valor, $tipo = 'M', $casas_decimais = null, $cifrao = "", $parenteses_para_negativo = false, $bValorQuantitativo = false) {
    /* MUDA FORMATO DA VALOR
      TIPO G = FORMATA PARA GRAVAR 0000.00
      TIPO M = FORMATA PARA MOSTRAR  0.000,00
      TIPO T = RETIRA OS ZEROS DO FINAL. Ex.: 5,50500 => 5,505
              PODE SER PASSADO UM NÚMERO INTEIRO APÓS O T PARA DEFINIR O MINIMO DE DECIMAIS
      EXEMPLOS:
        fValor('12,34500','G', 2) => 12.345
        fValor(12.34500,'M', 2) => 12,34
        fValor(12.34500,'M', 3) => 12,345
        fValor(12.34500,'M', 4) => 12,3450
        fValor(12.34500,'MT', 2) => 12,34
        fValor(12.34500,'MT', 3) => 12,345
        fValor(12.34500,'MT', 4) => 12,345 //Os zeros a direita são retirados
        fValor(12.34500,'MT2', 2) => 12,345
        fValor(12.34500,'MT2', 3) => 12,345
        fValor(12.34500,'MT2', 4) => 12,345
        fValor(12.3,'MT2', 2) => 12,30
        fValor(12.3,'MT2', 3) => 12,30
        fValor(12.3,'MT2', 4) => 12,30
    */

    global $CONFIG;

    if (is_null($casas_decimais) || ($casas_decimais === "") || (!is_numeric($casas_decimais))) {
      /* Quando o tipo for G ou MT e não possuir casas decimais define 4 que é o máximo que usamos,
      * se não usamos o que está na config da rede
      */
      $casas_decimais = (in_array($tipo, ['G', 'MT'])) ? 4 : $CONFIG->casas_decimais;
    }

    $casas_decimais = (int) $casas_decimais;

    if (!is_numeric($valor)) {
      $valor = preg_replace("/([^0-9\.,-]+)/", "", $valor);
      if (strrpos($valor, ',') > strrpos($valor, '.')) {
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
      } else {
        $valor = str_replace(",", "", $valor);
      }
    }

    if (!empty($valor) || ($valor == '0')) {
      if ($tipo[0] == "G") {
        if (is_numeric($valor)) {
          return number_format($valor, $casas_decimais, '.', '');
        } else {
          return null;
        }
      } else if ($tipo[0] == "M") {
        if (!$parenteses_para_negativo || $valor >= 0) {
          $valor = $cifrao . (!empty($cifrao) ? " " : "") . number_format($valor, $casas_decimais, ',', '.');
        } else {
          $valor = $cifrao . (!empty($cifrao) ? " " : "") . '(' . number_format(abs($valor), $casas_decimais, ',', '.') . ')';
        }

        if ($tipo[1] == "T") {
          $minCasasDecimais = min(intval($tipo[2]), $casas_decimais);
          $valor = rtrim($valor,"0");
          if ($minCasasDecimais > 0) {
            $qtdCasasDecimais = strlen(strstr($valor,",")) - 1;
            if ($qtdCasasDecimais < $minCasasDecimais)
              $valor = $valor . str_repeat('0', $minCasasDecimais - $qtdCasasDecimais);
          } else {
            $valor = rtrim($valor,",");

            if (strpos($valor, ",") === false) {
              $valor = str_replace(".", "", $valor);
            }
          }
          if($bValorQuantitativo == true) {
            $valor = rtrim(rtrim($valor, '0'), ',');
          }

          return $valor;
        }
        return $valor;
      }
    } else {
      if ($tipo[0] == "G") {
        return null;
      } else if ($tipo[0] == "M") {
        return "";
      }
    }
  }