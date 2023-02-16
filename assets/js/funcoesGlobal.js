$().ready(function () {
    setTimeout(function () {
        $('div.alert').delay(1500).fadeOut(400); // "div.alert" é a div que tem a class alert do elemento que deseja manipular.
    }, 2500); // O valor é representado em milisegundos.
});

// Removendo o atributo tittle para dispositivos moveis.
$(document).ready(function () {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $(".tip-top").removeAttr("title");
    }
});

function showTimer() {
    var time = new Date();
    var hour = time.getHours();
    var minute = time.getMinutes();
    var second = time.getSeconds();

    if (hour < 10) hour = "0" + hour;
    if (minute < 10) minute = "0" + minute;
    if (second < 10) second = "0" + second;

    var st = hour + ":" + minute + ":" + second; document.getElementById("timer").innerHTML = st;
}

function initTimer() {

    // O metodo nativo setInterval executa uma determinada funcao em um determinado tempo
    setInterval(showTimer, 1000);
}
/***** FUNCOES PARA STRING ******/
String.prototype.toDate = function(){
  if (this.indexOf('-') >= 0) {
    var ano = parseInt(this.substr(0,4), 10);
    var mes = parseInt(this.substr(5,2), 10);
    var dia = parseInt(this.substr(8,2), 10);
  } else {
    var dia = parseInt(this.substr(0,2), 10);
    var mes = parseInt(this.substr(3,2), 10);
    var ano = parseInt(this.substr(6,4), 10);
  }

  return new Date(ano,mes-1,dia);
}

Number.prototype.format = function(c, d, t){
var n = this,
  c = c == undefined ? config.casas_decimais || 2 : c,
  d = d == undefined ? "," : d,
  t = t == undefined ? "." : t,
  s = n < 0 ? "-" : "",
  i = parseInt(n = Math.abs(+n || 0).toFixed(c), 10) + "",
  j = (j = i.length) > 3 ? j % 3 : 0;
 return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

Number.prototype.formatFileSize = function(){
  var fileSizeInBytes = this;
  var i = -1;
  var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
  do {
      fileSizeInBytes = fileSizeInBytes / 1024;
      i++;
  } while (fileSizeInBytes > 1024);

  return Math.max(fileSizeInBytes, 0.1).toFixed(0) + byteUnits[i];
}

String.prototype.trimZeros = function(){
return( this.replace(new RegExp("[0,]+$", "gm"), "") );
}

String.prototype.trimRightZeros = function(c){
if (!!c) {
  var v = this.replace(new RegExp("0*$"),'');
  var n = v.split(',')[1].length;
  if (n < c) {
    v = v + '0'.repeat(c-n);
  }
} else {
  var v = this.replace(new RegExp("0*$"),'').replace(new RegExp(",*$"),'');
}
return v;
}

String.prototype.trim = String.prototype.trim || function(){
  return this.replace(new RegExp("^([\\s]+)|([\\s]+)$", "gm"), "");
}

String.prototype.trimLeft = String.prototype.trimLeft || function(){
  return this.replace(new RegExp("^[\\s]+", "gm"), "");
}

String.prototype.trimRight = String.prototype.trimRight || function(){
  return this.replace(new RegExp("[\\s]+$", "gm"), "");
}

String.prototype.isEmail = function () {
  return /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test(this.toLowerCase());
};

String.prototype.inArray = function(a) {
if (!(a && a.length)) return false;

for(var i=0; i<a.length; i++) {
  if (a[i] == this) return true;
}

return false;
}

/**
* Transforma, caractere por caractere conforme o equivalente, a string e
* retorna o resultado. A função já trata caracteres minúsculos e maiúsculos
*
* Exemplo: 'Construção' => 'Construcao'.
*
* @bManterEspacos boolean - Determina se os espaços em branco devem ser mantidos
*/
String.prototype.removeAcentos = function(bManterEspacos){
var r = this;

[
  ['[àáâãäå]', 'a'],
  ['[òóôõö]', "o"],
  ['æ', "ae"],
  ['ç', "c"],
  ['[èéêë]', "e"],
  ['[ìíîïî]', "i"],
  ['ñ', "n"],
  ['¶', "oe"],
  ['[ùúûü]', "u"],
  ['[ýÿ]', "y"]
].forEach(function(e, i) {
  r = r.replace(new RegExp(e[0], 'g'), e[1]);
  r = r.replace(new RegExp(e[0].toUpperCase(), 'g'), e[1].toUpperCase());
});

if (!bManterEspacos) {
  r = r.replace(new RegExp(/\s/g),"");
  r = r.replace(new RegExp(/\W/g),"");
}

return r;
};

String.prototype.contains = function(str, ignoreCase) {
return (ignoreCase ? this.toUpperCase() : this).indexOf(ignoreCase ? str.toUpperCase() : str) >= 0;
};

// Cria um filtro de contains case-insensitive para a jQuery
$.extend($.expr[':'], {
  icontains: function(a, i, m) {
      return $(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
  }
});

$.extend($.expr[':'], {
value: function(a) {
  return !!a && !!$(a).val() && $(a).val().toString().trim().length > 0;
}
});

// Como utilizar:
//var tag = 'A {0} eh {1} e a {0} eh {2}';
//var txt = tag.format('casa', 'amarela', 'bonita');
String.prototype.format = function() {
  var formatted = this;
  for (var i = 0; i < arguments.length; i++) {
      var regexp = new RegExp('\\{'+i+'\\}', 'gi');
      formatted = formatted.replace(regexp, arguments[i]);
  }
  return formatted;
};

//Capitaliza JS (uc_first php)
String.prototype.capitalize = function() {
return '{0}{1}'.format(this.charAt(0).toUpperCase(), this.slice(1));
};


String.prototype.parseUri = function(){
  return parseUri(this);
}

Date.prototype.addHoras = function(horas) {
  this.setHours(this.getHours() + horas);
};

Date.prototype.addMinutos = function(minutos) {
  this.setMinutes(this.getMinutes() + minutos);
};

Date.prototype.addSegundos = function(segundos) {
  this.setSeconds(this.getSeconds() + segundos);
};

Date.prototype.addDias = function(dias) {
  this.setDate(this.getDate() + dias);
};

Date.prototype.addMeses = function(meses) {
  this.setMonth(this.getMonth() + meses);
  return this;
};

Date.prototype.addAnos = function(anos) {
  this.setYear(this.getFullYear() + anos);
};

function jCalculaDataPeriodicidade(sData, sPeriodicidade) {
  var dData = sData.toDate();

  switch(sPeriodicidade) {
    case 'semanal':
      dData.addDias(7);
    break;
    case 'quinzenal':
      dData.addDias(15);
    break;
    case 'mensal':
      dData.addMeses(1);
    break;
    case 'bimestral':
      dData.addMeses(2);
    break;
    case 'trimestral':
      dData.addMeses(3);
    break;
    case 'semestral':
      dData.addMeses(6);
    break;
    case 'anual':
      dData.addAnos(1);
    break;
  }
  return dData;
}

function jDataFormatada(dDate) {
  var dia = dDate.getDate();
      dia = (dia < 10) ? '0' + dia : dia;
  var mes = dDate.getMonth() + 1;
      mes = (mes < 10) ? '0' + mes : mes;
  var ano = dDate.getFullYear();
  var sData = dia + '/' + mes + '/' + ano;

  return sData;
}

function jDataAtual() {
  var dData = new Date();

  return jDataFormatada(dData);
}

function jData(sData, sTipo) {
  sTipo = (!!sTipo) ? sTipo : 'M';
  sData = sData.trim();

  if ((!!sData) && (sData != '') && (sData != '0000-00-00') && (sData != '00/00/0000')) {

    var sAno  = '';
    var sMes  = '';
    var sDia  = '';
    var sHora = '';
    var aDataHora = sData.split(' ');
    sData = aDataHora[0];

    if (aDataHora.length > 1) {
      sHora = ' {0}'.format(aDataHora[1]);
    }

    if (sData.indexOf('-') > -1) {
      var aData = sData.split('-');

      if (aData.length > 2) {
        sAno = aData[0];
        sMes = aData[1];
        sDia = aData[2];
      }
    } else if (sData.indexOf('/') > -1) {
      var aData = sData.split('/');

      if (aData.length > 2) {
        sAno = aData[2];
        sMes = aData[1];
        sDia = aData[0];
      }
    }

    if ((sAno != '') && (sMes != '') && (sDia != '')) {
      if (sTipo == 'M') {
        return '{0}/{1}/{2}{3}'.format(sDia, sMes, sAno, sHora);
      } else if (sTipo == 'G') {
        return '{0}-{1}-{2}{3}'.format(sAno, sMes, sDia, sHora);
      }
    }
    return (sTipo == 'M') ? '' : null;
  } else {
    return (sTipo == 'M') ? '' : null;
  }
}

/**
 * Recebe os dias e/ou uma data e retorna a mesma formatada adicionando
 * a quantidade de dias a data informada ou a data atual se não for
 * informada uma data.
 *
 * @param int iDias - Quantidade de dias que deve ser somada a data
 * @param string sData - uma data no formato dd/mm/aaaa ou aaaa-mm-dd.
 * Caso não seja informada a data, a data atual é considerada
 *
 * @return string - String com a data formatada no padrão dd/mm/aaaa
 */
function jDataAddDias(iDias, sData) {
  var oData;
  iDias = jValor(iDias);

  if(!!sData) {
    sData = '{0} 00:00:00'.format(jData(sData, 'G'));
    oData = new Date(sData);
  } else {
    oData = new Date();
  }

  oData.addDias(iDias);
  return jDataFormatada(oData);
}

function jHoraAtual() {
  var dHora = new Date();

  var iHora = dHora.getHours();
      iHora = (iHora < 10) ? '0' + iHora : iHora;
  var iMinuto = dHora.getMinutes();
      iMinuto = (iMinuto < 10) ? '0' + iMinuto : iMinuto;
  var iSegundo = dHora.getSeconds();
      iSegundo = (iSegundo < 10) ? '0' + iSegundo : iSegundo;

  return iHora + ':' + iMinuto + ':' + iSegundo;
}

function jDataHoraAtual() {
  return jDataAtual() + ' ' + jHoraAtual();
}

function jValor(valor) {
  if (typeof(valor) == "string") {
    if (valor != "") {
      valor = valor.replace(/[^0-9.,-]/g, "");
      var posVirgula = valor.lastIndexOf(","),
          posPonto = valor.lastIndexOf(".");

      if (posVirgula > -1 && posPonto > -1) {
        if (posVirgula > posPonto) {
          valor = valor.replace(/\./g,"");
          valor = valor.replace(",",".");
        } else {
          valor = valor.replace(/\,/g,"");
        }
      } else {
        if (posVirgula > -1) {
          valor = valor.replace(",",".");
        }
      }
    } else {
      valor = 0;
    }
  } else {
    if (!valor) valor = 0;
  }
  return parseFloat(valor);
}

/**
 * Efetua o redirecionamento/carregamento da página via js
 *
 * @param url String - Endereço a ser carregado
 */
function jLocation(url) {
  if (!!window['ajaxEnabled']) {
    jAjaxLoad(url);
  } else {
    /**
     * Quando a url possuir um # e for a página atual, mesmo que
     * não seja a mesma #, usar apenas o assing acaba por não
     * recarregar a página.
     *
     * Ou seja, se passamos a mesma url, da página atual, para
     * função significa que desejamos recarregar a página, porém
     * com o # o navegador apenas reposiciona a tela sem
     * a recarregar.
     *
     * O fato de não recarregar a tela acaba por causar problemas
     * de usabilidade em determinados cruds.
     */
    if (url.contains('#') && url.split('#')[0] == location.href.split('#')[0]) {
      /**
       * Precisamos atualizar a url do navegador, pois pode ser uma # diferente da original
       *
       * Exemplo: a url era http://...sociado_detalhe&associado=420#ocorrencias e a nova
       * http://...sociado_detalhe&associado=420#usuarios
       */
      location.href = url;

      location.reload();
    } else {
      location.assign(url);
    }
  }
}

function handleMultiselectSimples(params) {
  let oParams = {
    header: false,
    autoWidth: false
  };

  if ($(this).prop('multiple')) {
    Object.assign(oParams, {
      multiple: true,
    });
  } else {
    Object.assign(oParams, {
      multiple: false,
      selectedList: 2  // Só para não ficar "1 selecionado"
    });
  }

  const iMinWidth = $(this).data('min-width');
  if (iMinWidth) {
    oParams.minWidth = iMinWidth;
  }

  const sNoneSelectedText = $(this).data('noneselectedtext');
  if (sNoneSelectedText) {
    oParams.noneSelectedText = sNoneSelectedText;
  }

  Object.assign(oParams, params);

  $(this).multiselect(oParams);
}

function handleSelectMultiplo(params) {
  var bHeader = $(this).data('header');
  if (bHeader == undefined) bHeader = true;

  var bFilter = false;
  //var bFilter = $(this).data('filter');
  if (bFilter == undefined) bFilter = true;

  var bHidden = $(this).css('display') == 'none';
  var bBtnAll = !!$(this).data('btnall') || true;
  var bMultiple = !!$(this).attr("multiple") || false;

  var h = $(this).multiselect({
    selectedList: $(this).data('items') || 20,
    header: bHeader,
    btnAll: bBtnAll,
    noneSelectedText: $(this).data('noneselectedtext') || '--- Selecione ---',
    selectedText: $(this).data('selectedtext') || '# selecionados',
    multiple: bMultiple,
    showBtnMostrarTodos: $(this).attr('showbtnmostrartodos') || false,
    btnMostrarTodos: $(this).attr('btnmostrartodos') || 'Mostrar Todos',
    showDisabled: $(this).attr('showdisabledoption') || false,
    marginClassBtnMostrarTodos: $(this).attr('marginclass') || 'ui-m-l-2',
    autoWidth: !!this.style.width,
    classSize: $(this).data('class-size') || ''
  });

  if (bHidden) {
    $(this).next().hide();
  }

  if (bHeader && bFilter) {
    h.multiselectfilter({
      label: '',
      placeholder: ''
    });
  }

  try {
    var jCallbackFn = $(this).data('callback-fn');
    if(!!jCallbackFn){
      window[jCallbackFn]();
    }
  } catch(e) {}
}

var handleFunctions = {
  'multiplo-simples': [handleMultiselectSimples, {}]
  , 'multiplo'      : [handleSelectMultiplo, {}]
};

$(function() {
  //Aplica os plugins aos respectivos inputs
  $('input[type=text], select, input[type=file], table, .thickbox, .tooltip, .btn-periodo, .switch, .switch-con, .help, .checkmark, .cores_dinamicas_click, .mobile-download').livequery(function() {
    var classes = this.className.split(/\s+/),
      i = 0,
      l = classes.length,
      handleFunction = null;

    for (; i < l; i++) {
      handleFunction = handleFunctions[classes[i]];
      if (handleFunction) {
        handleFunction[0].call(this, handleFunction[1]);
      }
    }
  });
});