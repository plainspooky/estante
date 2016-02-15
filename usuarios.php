<?php
/*
    ESTANTE
    Controle do acervo, empréstimos e usuários em uma pequena biblioteca.
    versáo 0.1a

    Usuários (módulo)

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

    include("tabelas_usuario.php");

    switch ( $MI_ACTN ){
        case 0:
        // Visualização
        print "<div class='modulo'>Usu&aacute;rios</div>\n";

        $DB_SORT=array("id_usuario","tx_nome_usuario","tx_doc_usuario","id_usuario","dt_nasc_usuario");

        if ( $MI_SORT<0 or $MI_SORT>=count($DB_SORT) ){
            $MI_SORT=0;
        }

        print show_letterbar($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR);

        $DB_BASE="SELECT".
            " id_usuario,".
            " concat(tx_nome_usuario,".
            " IF(st_status_usuario='B',".
            "\"&nbsp;<span class='atencao'>B</span>\"".
            ",'')),".
            " tx_doc_usuario,".
            " tx_tel_res_usuario,".
            " DATE_FORMAT(dt_nasc_usuario,'%d/%m/%Y') ".
            "FROM tb_usuarios ".
            "WHERE st_status_usuario<>'D' ";

        if ( $MI_LETR>2 ){
            $DB_BASE=$DB_BASE." AND LEFT(tx_nome_usuario,1)=\"".$MI_LBAR[$MI_LETR]."\"";
        } elseif ( $MI_LETR==2 ) {
            $DB_BASE=$DB_BASE." AND LEFT(tx_nome_usuario,1) BETWEEN \"0\" AND \"9\"";
        }

        if ( $MI_LETR>0 ) {
            $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE." ORDER BY ".$DB_SORT[$MI_SORT]);
                if ( $DB_SQL0 ) {
                    if ( db_num_rows($DB_SQL0) > 0 ) {
                        print ui_grid_table(
                            array("ID","NOME","DOCUMENTO","TELEFONE","NASC"),
                            $DB_SQL0,
                            "?o=".$MI_OPTN."&a=".$MI_ACTN."&i=0&e=0&l=".$MI_LETR."&s=",
                            "?o=".$MI_OPTN."&a=2&&s=".$MI_SORT."&e=0&l=".$MI_LETR."&i=",
                            array("5%","50%","15%","15%","15%")
                    );
                } else {
                    print display_message("N&atilde;o existem usu&aacute;rios em ".
                        "&quot;".$MI_LBAR[$MI_LETR]."&quot;");
                }
            } else {
                print display_error($DB_ERRO,$DB_BASE);
            }
        } else {
            print display_message("Selecione a letra inicial do nome ".
                "do usu&aacute;rio, &quot;9&quot; para os<br/>que ".
                "come&ccedil;arem com n&uacute;meros ou &quot;TODOS&quot; ".
                "para todos.");
        }
        break;

        case 1:
        // Inclusão
        print "<div class='modulo'>Incluir Usu&aacute;rio</div>\n"."<br/>";

        if ( $MI_SEGV>0 ) {
            $US_NOME=$_POST['form_nome'];
            $US_DOCU=$_POST['form_docu'];
            $US_ANON=(int)$_POST['form_anon'];
            $US_MESN=(int)$_POST['form_mesn'];
            $US_DIAN=(int)$_POST['form_dian'];
            $US_SEXO=$_POST['form_sexo'];
            $US_ESCO=(int)$_POST['form_esco'];
            $US_TRES=$_POST['form_tres'];
            $US_TCEL=$_POST['form_tcel'];
            $US_TCOM=$_POST['form_tcom'];
            $US_STAT=$_POST['form_stat'];

            $MI_ERRO="";

            include("verifica_usuario.php");

            if ( strlen($MI_ERRO)>0 ){
                print display_error("VERIFIQUE OS DADOS DIGITADOS",$MI_ERRO)."<br/>\n";
                include("formulario_usuario.php");
            } else {
                $US_NASC=$US_ANON."-".$US_MESN."-".$US_DIAN;

                $DB_SQL0="SELECT count(tx_doc_usuario) AS total ".
                    "FROM tb_usuarios ".
                    "WHERE tx_doc_usuario=\"".$US_DOCU."\" ".
                    "LIMIT 1";

                $MI_CONT=db_result(db_query($DB,$DB_DATA,$DB_SQL0),0,"total");

                if ( $MI_CONT>0 ){
                  print display_message("J&aacute; existe um usu&aacute;rio com este n&uacute;mero de documento!");
                  include("formulario_usuario.php");
                } else {
                    $DB_SQL1="INSERT INTO tb_usuarios ".
                        "(tx_nome_usuario, tx_doc_usuario,".
                        " dt_nasc_usuario, st_sexo_usuario,".
                        " nm_escol_usuario, tx_tel_res_usuario,".
                        " tx_tel_cel_usuario, tx_tel_com_usuario,".
                        " st_status_usuario) ".
                        "VALUES (".
                        format_in_quotes(array($US_NOME,$US_DOCU,$US_NASC,
                        $US_SEXO,$US_ESCO,$US_TRES,$US_TCEL,$US_TCOM,
                        $US_STAT)).")";

                        if ( db_query($DB,$DB_DATA,$DB_SQL1) ){
                            print display_message("Registro Inserido");
                        } else {
                            print display_error($DB_ERRO,$DB_SQL1);
                            $MI_ACTN=-1;
                        }
                }
            }
        } else {
            $US_NOME="";
            $US_DOCU="";
            $US_ANON="";
            $US_MEMN="";
            $US_DIAN="";
            $US_SEXO="M";
            $US_ESCO=1;
            $US_TRES="";
            $US_TCEL="";
            $US_TCOM="";
            $US_STAT="B";
            include("formulario_usuario.php");
        }
        break;

        case 2:
        // Exibir/Edição
        $DB_BASE="SELECT".
            " tx_nome_usuario, tx_doc_usuario,".
            " dt_nasc_usuario, nm_escol_usuario,".
            " st_sexo_usuario, tx_tel_res_usuario,".
            " tx_tel_cel_usuario, tx_tel_com_usuario,".
            " st_status_usuario ".
            "FROM tb_usuarios ".
            "WHERE id_usuario=\"".$MI_REGI."\" ".
            "LIMIT 1";

        $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

        $DB_CONT=db_num_rows($DB_SQL0);

        if ( $DB_CONT==1 ){
            print "<div class='modulo'>Registro #".$MI_REGI."</div>\n<br/>\n";

            $DB_LINE=db_fetch_array($DB_SQL0);

            list( $US_NOME, $US_DOCU, $US_NASC,$US_ESCO, $US_SEXO, $US_TRES,$US_TCEL, $US_TCOM, $US_STAT  ) = $DB_LINE;

            list($US_ANON,$US_MESN,$US_DIAN)=split("-",$US_NASC);

            if ( $MI_SEGV>0 ) {
                $US_NOME=$_POST['form_nome'];
                $US_DOCU=$_POST['form_docu'];
                $US_ANON=(int)$_POST['form_anon'];
                $US_MESN=(int)$_POST['form_mesn'];
                $US_DIAN=(int)$_POST['form_dian'];
                $US_SEXO=$_POST['form_sexo'];
                $US_ESCO=(int)$_POST['form_esco'];
                $US_TRES=$_POST['form_tres'];
                $US_TCEL=$_POST['form_tcel'];
                $US_TCOM=$_POST['form_tcom'];
                $US_STAT=$_POST['form_stat'];

                $MI_ERRO="";

                include("verifica_usuario.php");

                if ( strlen($MI_ERRO)>0 ){
                    print display_error("VERIFIQUE OS DADOS DIGITADOS:",$MI_ERRO)."<br/:\n";
                    include("formulario_usuario.php");
                } else {
                    $US_NASC=$US_ANON."-".$US_MESN."-".$US_DIAN;

                    $DB_BASE="UPDATE tb_usuarios SET ".
                    format_in_equals(
                        array("tx_nome_usuario","tx_doc_usuario",
                    	   "dt_nasc_usuario","st_sexo_usuario",
                    	   "nm_escol_usuario","tx_tel_res_usuario",
                    	   "tx_tel_cel_usuario","tx_tel_com_usuario",
                    	   "st_status_usuario"),
                        array($US_NOME, $US_DOCU,
                            $US_NASC, $US_SEXO,
                            $US_ESCO, $US_TRES,
                            $US_TCEL, $US_TCOM,
                            $US_STAT))." ".
                        "WHERE id_usuario=\"".$MI_REGI."\" ".
                        "LIMIT 1";

                    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                    if ( $DB_SQL0 ){
                        print display_message("Registro #".$MI_REGI." alterado");
                        $MI_ACTN=1;
                    } else {
                        print display_error($DB_ERRO,$DB_BASE)."<br/>\n";
                        $MI_ACTN=-1;
                    }
                }
            } else {
                include("formulario_usuario.php");
        } else {
            print display_message("Registro n&atilde;o encontrado");
            $MI_ACTN=-1;
        }
        break;

        case 3:
        // Histórico
        $DB_BASE="SELECT".
            " tx_nome_usuario, tx_doc_usuario ".
            "FROM tb_usuarios ".
            "WHERE id_usuario=\"".$MI_REGI."\" ".
            "LIMIT 1";

        $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

        $DB_CONT=db_num_rows($DB_SQL0);

        if ( $DB_CONT==1 ){
            print "<div class='modulo'>Hist&oacute;rico do Usu&aacute;rio</div>\n<br/>\n";
            $DB_LINE=db_fetch_array($DB_SQL0);

            list( $US_NOME, $US_DOCU ) = $DB_LINE;

            print "<div class='caixa'>\n";
            print "<div class='autor'>".$US_NOME."</div>\n";

            $DB_BASE="SELECT".
                " a.id_livro,".
                " b.tx_titulo_livro,".
                " b.tx_autor_livro,".
                " DATE_FORMAT(a.dt_inicio_historico,'%d/%m/%Y') ini,".
                " DATE_FORMAT(a.dt_fim_historico,'%d/%m/%Y') fim,".
                " DATE_FORMAT(a.dt_devol_historico,'%d/%m/%Y') dev ".
                "FROM".
                " tb_historicos AS a,".
                " tb_livros AS b ".
                "WHERE".
                " a.id_usuario='".$MI_REGI."' AND ".
                " a.id_livro=b.id_livro ".
                "ORDER BY".
                " a.id_historico";

            $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

            if ( $DB_SQL0 ){
                $MI_TOTAL=db_num_rows($DB_SQL0);
                if ( $MI_TOTAL>0 ){
                    print "<table cellspacing='0px' cellpadding='0px'>\n".
                        "<tr>\n".
                        "<th width='55%'>T&Iacute;TULO / AUTOR</th>".
                        "<th width='15%'>RETIRADA</th>".
                        "<th width='15%'>DEVOLVER AT&Eacute;</th>".
                        "<th width='15%'>DEVOLU&Ccedil;&Atilde;O</th>".
                        "</tr>\n";

                    while ( $MI_LINE=db_fetch_array($DB_SQL0) ){
                        print "<tr>\n".
                            "<td><a href='".
                            format_get(
                            array(0,2,$MI_LINE['id_livro'],$MI_SORT,0,$MI_LETR)
                            ).
                            "'>&quot;".$MI_LINE['tx_titulo_livro'].
                            "&quot; / ".$MI_LINE['tx_autor_livro']."</a></td>".
                            "<td>".$MI_LINE['ini']."</td>".
                            "<td>".$MI_LINE['fim']."</td>".
                            "<td";

                        $I=split("/",$MI_LINE['fim']);
                        $MI_FINAL=mktime(0,0,0,$I[1],$I[0],$I[2]);

                        $I=split("/",$MI_LINE['dev']);
                        $MI_DEVOL=mktime(0,0,0,$I[1],$I[0],$I[2]);

                        if ( $MI_DEVOL>$MI_FINAL ){
                          print " style='color:#a21'";
                        }

                        print ">".$MI_LINE['dev']."</td>".
                              "</tr>\n";
                      }

                  print "</table>\n".
                  "&nbsp;Total de ".$MI_TOTAL." registro(s)<br/>\n";
                } else {
                  print display_message("N&atilde;o existe hist&oacute;rico".
                    " do livro!")."<br/>\n";
                }
            } else {
                print display_error($DB_ERRO,$DB_BASE);
            }
            print "</div>\n";
        } else {
            print display_message("Registro n&atilde;o encontrado");
            $MI_ACTN=-1;
        }
        break;

        case 4:
        // Remoção
        $DB_BASE="SELECT".
            " tx_nome_usuario ".
            "FROM tb_usuarios ".
            "WHERE id_usuario=\"".$MI_REGI."\" ".
            "LIMIT 1";

            $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

            $DB_CONT=db_num_rows($DB_SQL0);

        if ( $DB_CONT==1 ){
            print "<div class='modulo'>Registro #".$MI_REGI."</div>\n<br/>\n";

            $DB_LINE=db_fetch_array($DB_SQL0);
            $US_NOME=$DB_LINE['tx_nome_usuario'];

            if ( $MI_SEGV>0 ){
                // eu n]ao posso apagar um usuário enquanto tiver livros com ele
                $DB_BASE="SELECT".
                    " id_emprestimo ".
                    "FROM".
                    " tb_emprestimos ".
                    "WHERE".
                    " id_usuario=\"".$MI_REGI."\" ".
                    "LIMIT 1";

                $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                $DB_CONT=db_num_rows($DB_SQL0);

                if ( $DB_CONT>0 ){
                    print "<div class='aviso'>\n".
                    "Usu&aacute;rio com empr&eacute;stimos pendentes!".
                    "</div>\n";

                    $MI_ACTN=-1;
                } else {
                    $DB_BASE="UPDATE tb_usuarios SET ".
                        format_in_equals(
                        array("st_status_usuario"),
                        array("D"))." ".
                        "WHERE id_usuario=\"".$MI_REGI."\" ".
                        "LIMIT 1";

                    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                    if ( $DB_SQL0 ){
                        print display_message("Registro #".$MI_REGI." Apagado");
                        $MI_ACTN=1;
                    } else {
                        print display_error($DB_ERRO,$DB_BASE)."<br/>\n";
                        $MI_ACTN=-1;
                    }
                }
            } else {
                print "<form action=\"".
                    format_get(
                    array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR)).
                    "\" method=\"post\">\n";

                print "<div class='caixa'>\n".
                    ui_input_hidden("sv","1").
                    "<div class='aviso'>".
                    "Deseja realmente apagar o(a) usu&aacute;rio(a):<br/>\n".
                    $US_NOME."?<br/><br/>\n".
                    "<input class='botao' type=\"submit\" value=\"Apagar!\">".
                    "</div>\n".
                    "</div>\n";

                print "</form>\n";

                $MI_ACTN=-1;
            }
        } else {
            print display_message("Registro n&atilde;o encontrado");
            $MI_ACTN=-1;
    }
    break;

        default:
        print display_message("A&ccedil;&atilde;o Inv&aacute;lida");
        $MI_ACTN=-1;
    }

    /*
        submenu (muda de acordo com a opção selecionada)
    */
    switch( $MI_ACTN ){
        case -1:
        $MI_MENU=array("Registros");
        $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)));
        break;

        case 0:
        $MI_MENU=array("Incluir");
        $MI_LINK=array(format_get(array($MI_OPTN,1,0,$MI_SORT,0,$MI_LETR)));
        break;

    case 1:
        $MI_MENU=array("&lt;","Ver Registros");
        $MI_LINK=array("javascript:history.go(-1);",
            format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)));
        break;

    default:
        $MI_MENU=array("Retornar",
            "Incluir",
            "Hist&oacute;rico",
            "Apagar");
        $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)),
            format_get(array($MI_OPTN,1,0,$MI_SORT,0,$MI_LETR)),
            format_get(array($MI_OPTN,3,$MI_REGI,$MI_SORT,0,$MI_LETR)),
            format_get(array($MI_OPTN,4,$MI_REGI,$MI_SORT,0,$MI_LETR)));
    }

    print "<br/>\n".
        "<div class='submenu'>".display_submenu($MI_MENU,$MI_LINK)."</div>";
?>
