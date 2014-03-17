<?php
/*
  ESTANTE
  Controle do acervo, empréstimos e usuários em uma pequena biblioteca.
  versão 0.1

  Consultas (módulo)

  Copyright (C) 2005  Giovanni Nunes <bitatwork@yahoo.com>

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

  print "<div class='modulo'>Relat&oacute;rios</div>\n";

  $MI_RELT=array("",
                 "CONSULTA AO ACERVO",
                 "HIST&Oacute;RICO GERAL",
		 "LISTA DE USU&Aacute;RIOS",
		 "STATUS DA BIBLIOTECA");
		 
  print "<div class='letra'>\n";

  for ( $I=1; $I<count($MI_RELT); $I++ )
  {
    print "<a href=\"".
          format_get(array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$I)).
	  "\"><span class='letra'>".$MI_RELT[$I]."</span></a> ";
  }
  
  print "</div>\n";

  if ( $MI_LETR>0 )
  {
     print "<br/>\n".
  	   "<div class='caixa'>\n";
  }
  
  switch( $MI_LETR )
  {
    case 0:
    print display_message("Selecione a ".
          "Consulta desejada");
    break;

    case 1:
    /*
    consulta ao acervo
    */
    switch( $MI_SEGV )
    {
      case 0:
      /*
      entrada de dados
      */
      print "<h1>Consulta ao Acervo</h1>\n".
            "<br/>\n";
	  
      print "<form action=\"".format_get(array($MI_OPTN,0,0,0,0,1))."\" ".
            "method=\"post\">\n".
	    ui_input_hidden("sv","1");
    
      print "<div class='consulta'>".
            "<span class='consulta'><b>Aten&ccedil;&atilde;o:</b><br/>\n".
	    "Digite o texto no campo abaixo evitando usar palavras de uso ".
	    "comum como preposi&ccedil;&otilde;es e artigos.".
	    "</span>".
	    "<div>\n".
	    ui_input("Procurar por:<br/>","form_strn",48,"").
	    "</div>\n".
            "<div>\n".
	    ui_combo_box("Em:<br/>","form_fild",1,
	    array("T&iacute;tulo","Autor","CIP","Editora","ISBN","Palavras Chave")).
	    "</div>\n".
            "<br/>\n".
            "<div class='botao'>".
            "<input class='botao' type=\"submit\" value=\"Pesquisar\">\n".
            "</div>\n".
	    "</div>\n";

      print "</form>\n".
            "<br/>\n";
      break;

      case 1:
      /*
      resultado da pesquisa
      */
      print "<h1>Resultado da Pesquisa</h1>\n";

      $QY_STRN=$_POST['form_strn'];
    
      $QY_FILD=(int)$_POST['form_fild']-1;
    
      $MI_FILD=array("tx_titulo_livro",
                     "tx_autor_livro",
   	  	     "tx_cip_livro",
		     "tx_editora_livro",
		     "tx_isbn_livro",
		     "tx_assunto_livro");

      if ( $QY_FILD<0 or $QY_FILD>count($MI_FILD) )
      {
        $QY_FILED=0;
      }
    
      $DB_BASE="SELECT".
               " id_livro,".
	       " tx_titulo_livro,".
	       " tx_autor_livro,".
	       " tx_editora_livro,".
	       " tx_isbn_livro ".
	       "FROM".
	       " tb_livros ";

      $QY_ITEM=split(" ",$QY_STRN);

      $DB_FILD="WHERE ";
      
      $I=count($QY_ITEM);
    
      for ( $J=0; $J<$I; $J++ )
      {
        $DB_FILD.="`".$MI_FILD[$QY_FILD].
	          "` LIKE \"%".$QY_ITEM[$J]."%\"";

        if ( $J!=($I-1) )
        {
          $DB_FILD.=" OR ";
        }
      }
    
      $DB_FILD.=" AND st_status_livro<>'D'";

      $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE." ".$DB_FILD);

      if ( db_num_rows($DB_SQL0)> 0 )
      {
        print "<br/>\n".
              "<div class='caixa'>\n".
	      "<span class='consulta'>T&iacute;tulo(s) encontrado(s):</span>".
	      "<br/>\n";

        $I=1;

        while ( $DB_LINE=db_fetch_array($DB_SQL0) )
        {
          print "<div class='";
	
          if ( $I<1 )
          {
            print "linha_par";
          }
          else
          {
            print "linha_impar";
          }

	  print "'>".
	        "<a href=\"".format_get(array(0,2,$DB_LINE[0],0,0,0))."\">".
	        "<b>".$DB_LINE[1]."</b></a> (ISBN ".$DB_LINE[4]."), ".
	        $DB_LINE[3]."<br/>\n".
	        format_author($DB_LINE[2])."</div>";

	  $I=$I*-1;
        }
        print "</div>\n<br/>";
      }
      else
      {
        print display_message("Nenhum registro encontrado");
      }
    }
    break;
    
    case 2:
    /*
    Histórico Geral (do Acervo)
    */
    print "<h1>Hist&oacute;rico Geral</h1>\n";

    print "<p>Vers&atilde;o preliminar</p>\n";

    $DB_BASE="SELECT".
             " id_livro,".
	     " tx_titulo_livro ".
	     "FROM".
	     " tb_livros ".
	     "ORDER BY tx_titulo_livro";

    $I=0;
    
    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

    while ( $DB_LIN0=db_fetch_array($DB_SQL0) )
    {
      $RE_LIVR=(int)$DB_LIN0['id_livro'];
      
      print "<h3>".$DB_LIN0['tx_titulo_livro']."</h3>\n";

      $DB_BASE="SELECT".
               " id_usuario,".
               " tx_usuario_historico,".
               " DATE_FORMAT(dt_inicio_historico,'%d/%m/%y'),".
               " DATE_FORMAT(dt_fim_historico,'%d/%m/%y'),".
               " DATE_FORMAT(dt_devol_historico,'%d/%m/%y') ".
	       "FROM".
	       " tb_historicos ".
	       "WHERE".
	       " id_livro='".$RE_LIVR."' ".
	       "ORDER BY".
	       " dt_inicio_historico";
     
      $DB_SQL1=db_query($DB,$DB_DATA,$DB_BASE);
      
      print ui_grid_table(
            array("ID","USUARIO","RETIRADA","DEVOLVER AT&Eacute;",
	          "DEVOLU&Ccedil;&Atilde;O"),
            $DB_SQL1,
            "",
            "",
	    array("5%","50%","15%","15%","15%") 
            );
	    
      $I++;
    }
    
    print "<br/>\n".
          "TOTAL GERAL DE ".$I." REGISTRO(S)<br/>\n";

    break;

    case 3:
    print "<h1>Lista de Usu&aacute;rios</h1>\n";

    /*
    primeira encarnação do módulo, apenas uma lista simples
    */
    print "<p>Vers&atilde;o preliminar</p>\n";

    $DB_BASE="SELECT".
             " id_usuario,".
	     " tx_nome_usuario,".
	     " tx_doc_usuario,".
	     " dt_nasc_usuario,".
	     " st_sexo_usuario,".
	     " nm_escol_usuario,".
	     " tx_tel_res_usuario,".
             " tx_tel_cel_usuario,". 
             " tx_tel_com_usuario,". 
             " st_status_usuario ".
	     "FROM".
	     " tb_usuarios ".
	     "ORDER BY tx_nome_usuario";

    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

    print ui_grid_table(
          array("ID","NOME","DOC","NASC","SEXO","ESCO","RES","CEL","COM","STA"),
          $DB_SQL0,
          "",
          "",
	  ""
          );
    
    break;

    case 4:
    /*
    status da biblioteca
    */
    print "<h1>Status da Biblioteca</h1>\n".
          "<table width='100%' cellspacing='0px' cellpadding='0px'>\n".
          "<tr>\n".
	  "<th colspan='3'>Acervo</th>".
	  "<th colspan='3'>Usu&aacute;rios</th>".
	  "<th colspan='2'>Empr&eacute;stimos</th>".
	  "<th>Hist&oacute;rico</th>".
	  "</tr>\n";

    $MI_TDAY=date("Y-m-d",time());
 
    $RE_WIDT=array(10,10,10,10,10,10,10,10,20);

    $RE_CELS=array("Biblioteca","Emprestados","Total",
                   "Ativo(s)","Bloqueado(s)","Total",
                   "Hoje","Atrasado(s)",
		   "Total de Empr&eacute;stimos");

    $RE_VALS=array(-1,-1,-1,-1,-1,-1,-1,-1,-1,);

    /*
    a totalização é bastante repetitiva, assim além de mais simples para
    os olhos ficou, também, mais elegante.
    */
    $RE_SQLS=array("",
                   "SELECT COUNT(id_emprestimo) AS s ".
		   "FROM tb_emprestimos",
                   "SELECT COUNT(id_livro) AS s ".
		   "FROM tb_livros WHERE st_status_livro<>'D'",
                   "SELECT COUNT(id_usuario) AS s ".
		   "FROM tb_usuarios WHERE st_status_usuario='A'",
		   "SELECT COUNT(id_usuario) AS s ".
		   "FROM tb_usuarios WHERE st_status_usuario='B'",
		   "",
 	           "SELECT COUNT(id_emprestimo) AS s ".
		   "FROM tb_emprestimos WHERE dt_fim_emprestimo='".$MI_TDAY."'",
		   "SELECT COUNT(id_emprestimo) AS s ".
		   "FROM tb_emprestimos WHERE dt_fim_emprestimo<'".$MI_TDAY."'",
     	           "SELECT COUNT(id_historico) AS s ".
		   "FROM tb_historicos");

    for ( $I=0; $I<count($RE_SQLS); $I++ )
    {
      if ( strcmp($RE_SQLS[$I],"")<>0 )
      {
        $RE_FTCH=db_fetch_array(db_query($DB,$DB_DATA,$RE_SQLS[$I]));
	
        $RE_VALS[$I]=$RE_FTCH['s'];
      }
    }

    /*
      alguns valores são calculados e ficam por último
    */
    $RE_VALS[5]=$RE_VALS[3]+$RE_VALS[4];
    $RE_VALS[0]=$RE_VALS[2]-$RE_VALS[1];

    print "<tr valign='top'>\n";
    
    for ( $I=0; $I<count($RE_CELS); $I++ )
    {
      print "<td width='".$RE_WIDT[$I]."%'>".
            $RE_CELS[$I].":<br/><b>".$RE_VALS[$I]."</b>".
	    "</td>";
    }
   
    print "</tr>\n";
    
    print "<tr valign='top'>\n";
	 
    /*
    os 10 livros mais emprestados
    */
    print "<td colspan='5'>".
          "<h3>OS DEZ T&Iacute;TULOS MAIS EMPRESTADOS</h3>\n";
	  
    $DB_BASE="SELECT".
	     " b.tx_titulo_livro,".
	     " COUNT(a.id_livro) AS soma ".
	     "FROM".
	     " tb_historicos AS a,".
	     " tb_livros AS b ".
	     "WHERE".
	     " a.id_livro=b.id_livro ".
	     "GROUP BY a.id_livro ".
	     "ORDER BY soma DESC ".
	     "LIMIT 10";
	     
    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

    print ui_grid_table(
          array("T&Iacute;TULO DO ACERVO","EMPS"),
          $DB_SQL0,
          "",
          "",
	  array("90%","10%")
          );

    print "</td>\n";
    
    /*
    os 10 usuarios mais ativos (eu sei que o termo é horrível)
    */
    print "<td colspan='4'>".
          "<h3>OS DEZ USU&Aacute;RIOS MAIS ATIVOS*</h3>\n";
	  
    $DB_BASE="SELECT".
             " tx_usuario_historico,".
	     " COUNT(id_usuario) AS soma ".
	     "FROM".
	     " tb_historicos ".
	     "GROUP BY id_usuario ".
	     "ORDER BY soma DESC ".
	     "LIMIT 10";
	     
    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

    print ui_grid_table(
          array("NOME DO USU&Aacute;RIO","EMPS"),
          $DB_SQL0,
          "",
          "",
	  array("90%","10%")
          );

    print "(*) Preciso de um nome melhor</td>\n".
          "</tr>\n".
          "</table>\n";
	  
    break;

    default:
    print "<div class='aviso'>Op&ccedil;&atilde;o Inv&aacute;lida!</div>\n";
  }
  
  if ( $MI_LETR>0 )
  {
    print "</div>\n";
  }

  print "<br/>\n";

?>
