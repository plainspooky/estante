<?php
/*
  ESTANTE
  Controle do acervo, empréstimos e usuários em uma pequena biblioteca.
  versão 0.2

  Copyright (C) 2005  Giovanni Nunes <giovanni.nunes@gmail.com>

  This program is free software; you can redistribute it and/or modify it under
  the terms of the GNU General Public License as published by the the Free
  Software Foundation; either version 2 of the License, or (at your option) any
  later version. 

  This program is distributed in the hope that it will be useful, but WITHOUT
  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
  FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
  details.

  You should have received a copy of the GNU General Public License along with
  this program; if not, write to the Free Software Foundation, Inc., 59 Temple
  Place, Suite 330, Boston, MA  02111-1307  USA
*/

/*
  recupera a configuração do programa e faz a validação de alguns
  parâmetros iniciais
*/
  include("configuracao.php");
  
  if ( empty($MI_CONF) )
  {
    exit("<html>\n<body>PROGRAMA N&Atilde;O CONFIGURADO!</body>\n</html>");
  }
  else
  {
    include($MI_CONF);
  }

  if ( empty($DB_SGBD) )
  {
    exit("<html>\n<body>SGBD N&Atilde;O DEFINIDO!</body>\n</html>");
  }

  if ( empty($MI_LIBS_DIR) )
  {
    exit("<html>\n<body>PROGRAMA CONFIGURADO INCORRETAMENTE</body>\n<html>");
  }
   
/*
  bibliotecas de rotinas
*/
  include($MI_LIBS_DIR."/".$DB_SGBD.".php"); 
  include($MI_LIBS_DIR."/xhtml.php");
  include($MI_LIBS_DIR."/ui.php");
  include($MI_LIBS_DIR."/estante.php");

/*
  formatação da URL dos links
*/
function format_get($VALUES)
{
  $GETS=array("o","a","i","s","e","l");
 
  $INDEX="?";
  
  $I=count($VALUES)-1;

  for ( $J=0; $J<=$I; $J++ )
  {
    $INDEX=$INDEX.$GETS[$J]."=".$VALUES[$J];

    if ( $J<$I )
    {
      $INDEX=$INDEX."&";
    }
  }
  return $INDEX;
}

/*
  início do programa
*/
  setlocale(LC_ALL,$MI_LOCALE);

  $DB=array($DB_HOST.$DB_PORT,$DB_USER,$DB_PASS);
 
  $MI_VERS="0.1";
  $MI_PROG="Estante";
  $MI_PDSC="Controle do acervo, empr&eacute;timos e usu&aacute;rios em uma ".
           "pequena biblioteca.\n";

  $DB_ERRO="FALHA AO ACESSAR O BANCO DE DADOS";

  $MI_PICT_DIR=$MI_HTTP_DIR."/imagens";
  $MI_STYL_DIR=$MI_HTTP_DIR."/estilos";

/*
  outras informações
*/
  $MI_AUTH=$MI_PROG." versão ".$MI_VERS;
  $MI_KEYS="GNU, Linux, Apache, PHP, MySQL, Controle de Bibliotecas";
  $MI_DESC="programa bem simples para o controle de uma biblioteca";
  $MI_STYL=$MI_STYL_DIR."/style.css";

  $MI_MENU=array("Acervo","Usu&aacute;rios","Empr&eacute;stimos",
                 "Consultas","Sobre");

  /*
  Usado para montar a query, não apague!
  */
  $MI_LBAR=array("","*","9","A","B","C","D","E","F","G","H","I","J","K","L",
                 "M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

/*
  recupera as informações passadas via GET
*/
  $MI_OPTN=(int)$_GET['o'];
  $MI_ACTN=(int)$_GET['a'];
  $MI_REGI=(int)$_GET['i']; 
  $MI_SORT=(int)$_GET['s'];
  $MI_EDIT=(int)$_GET['e'];
  $MI_LETR=(int)$_GET['l'];

/*
  evita problemas com a variável MI_OPTN
*/
  if ( $MI_OPTN<0 or $MI_OPTN>=count($MI_MENU) )
  {
    $MI_OPTN=0;
  }

/*
  evita problemas com a variável MI_LETR
*/
  if ( $MI_LETR<0 or $MI_LETR>=count($MI_LBAR) )
  {
    $MI_LETR=0;
  }

/*
  recupera as informações passadas via POST
*/
  $MI_SEGV=(int)$_POST['sv'];
  
/*
  o nome do programa e em que modo se está
*/
  $MI_TITL=$MI_PROG." (".$MI_MENU[$MI_OPTN].")";

/*
  aqui começa o XHTML (finalmente)
*/
  print xhtml_begin($MI_LANG).
        xhtml_header($MI_CHAR,$MI_AUTH,$MI_KEYS,$MI_DESC,$MI_STYL,$MI_TITL).
        xhtml_begin_body();

/*
  toda saída impressa fica dentro deste <DIV>
*/
  print "<div class='janela'>\n";

/*
  nome do programa
*/
  print "<div class='programa'>\n".
        "<div id='programa'>".$MI_NAME."</div>\n".
        "<div id='progdesc'>".$MI_SUBT."</div>\n".
        "</div>\n";

/*
  menu principal
*/
  print "<div class='menu'>\n".
        "<div class='sombra'></div>\n".
        "<div>";

  /*
  desenha o menu
  */
  for ( $I=0; $I<count($MI_MENU); $I++ )
  {
    if ( $I==$MI_OPTN )
    {
      print "<span class='menu'>".$MI_MENU[$I]."</span>";
    }
    else
    {
      print "<a class='menu' href=\"".
            format_get(array($I,0,0,0,0,0))."\">".
            $MI_MENU[$I]."</a>";
    }	    
  }
  
  print "</div>\n".
        "</div>\n";

  /*
  verifica qual módulo deve ser usado
  */
  switch ( $MI_OPTN )
  {
    case 0:
    include($MI_HOME_DIR."/livros.php");
    break;

    case 1:
    include($MI_HOME_DIR."/usuarios.php");
    break;
    
    case 2:
    include($MI_HOME_DIR."/emprestimos.php");
    break;

    case 3:
    include($MI_HOME_DIR."/consultas.php");
    break;

    case 4:
    include($MI_HOME_DIR."/sobre.php");
    break;
    
    default:
    print display_message("Op&ccedil;&atilde;o Inv&aacute;lida").
          "<br/>";

  }

/*
  encerra o <DIV> principal
*/
  print "</div>\n".
        "<div class='fundo'></div>\n";

/*
  nossos patrocinadores
*/
  print "<div class='rodape'>\n".
        "<div class='sombra'></div>\n".
        "</div>\n";

/*
  encerra o XHTML
*/
  print xhtml_end_body().
        xhtml_end();

/* MSX RULEZ! */
?>
