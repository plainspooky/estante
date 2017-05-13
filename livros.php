<?php
/*
    ESTANTE
    Controle do acervo, empr�stimos e usu�rios em uma pequena biblioteca.
    vers�o 0.1

    Acervo (m�dulo)

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

    switch ( $MI_ACTN )
    {
        case 0:
        // Visualização
        print "<div class='modulo'>Acervo da Biblioteca</div>\n";

        $DB_SORT=array(
        "id_livro",
        "tx_titulo_livro",
        "tx_autor_livro",
        "tx_editora_livro",
        "tx_isbn_livro");

        if ( $MI_SORT<0 or $MI_SORT>=count($DB_SORT) ){
            $MI_SORT=0;
        }

        print show_letterbar($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR);

        $DB_BASE="SELECT".
        " id_livro,".
        " tx_titulo_livro,".
        " tx_autor_livro,".
        " tx_editora_livro,".
        " tx_isbn_livro ".
        "FROM tb_livros ".
        "WHERE st_status_livro<>'D'";

        if ( $MI_LETR>2 ){
            $DB_BASE=$DB_BASE." AND LEFT(tx_titulo_livro,1)=\"".$MI_LBAR[$MI_LETR]."\"";
        } elseif ( $MI_LETR==2 ) {
            $DB_BASE=$DB_BASE." AND LEFT(tx_titulo_livro,1) BETWEEN \"0\" AND \"9\"";
        }

        if ( $MI_LETR>0 ){
            $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE." ORDER BY ".$DB_SORT[$MI_SORT]);

            if ( $DB_SQL0 ){
                if ( db_num_rows($DB_SQL0) > 0 ){
                    print ui_grid_table(
                    array("ID","T&Iacute;TULO","AUTOR(ES)","EDITORA","ISBN"),
                    $DB_SQL0,
                    "?o=".$MI_OPTN."&a=".$MI_ACTN."&i=0&e=0&l=".$MI_LETR."&s=",
                    "?o=".$MI_OPTN."&a=2&&s=".$MI_SORT."&e=0&l=".$MI_LETR."&i=",
                    array("5%","35%","30%","20%","10%"));
                } else {
                    print display_message("N&atilde;o existem livros em &quot;".
                    $MI_LBAR[$MI_LETR]."&quot;!")."<br/>\n";
                }
            } else {
                print display_error($DB_ERRO,$DB_BASE."...");
            }
        } else {
            print display_message("Selecione a letra inicial do t&iacute;tulo ".
            "do livro, &quot;9&quot; para os que<br/>come&ccedil;am com ".
            "n&uacute;meros ou &quot;TODOS&quot; para todo o acervo");
        }
        break;

        case 1:
        // Inclusão
        print "<div class='modulo'>Incluir Publica&ccedil;&atilde;o</div>\n".
        "<br/>\n";

        if ( $MI_SEGV>0 ) {
            $LV_TITL=$_POST['form_titl'];
            $LV_AUTO=$_POST['form_auto'];
            $LV_ISBN=$_POST['form_isbn'];
            $LV_CLAS=$_POST['form_clas'];
            $LV_PHAL=$_POST['form_phal'];
            $LV_EDIT=$_POST['form_edit'];
            $LV_CIDA=$_POST['form_cida'];
            $LV_UNFE=$_POST['form_unfe'];
            $LV_EDIC=$_POST['form_edic'];
            $LV_VOLU=$_POST['form_volu'];
            $LV_PATR=$_POST['form_patr'];
            $LV_PAGS=$_POST['form_pags'];
            $LV_ANOL=$_POST['form_anol'];
            $LV_CIPL=$_POST['form_cipl'];
            $LV_ASSU=$_POST['form_assu'];

            $MI_ERRO="";

            include("verifica_livro.php");

            if ( strlen($MI_ERRO)>0 ){
                print display_error("VERIFIQUE OS DADOS DIGITADOS",$MI_ERRO)."<br/>\n";
                include("formulario_livro.php");
            } else {
                $DB_SQL0="SELECT count(tx_isbn_livro) AS total ".
                "FROM tb_livros ".
                "WHERE tx_isbn_livro=\"".$LV_ISBN."\" ".
                "LIMIT 1";

                $MI_CONT=db_result(db_query($DB,$DB_DATA,$DB_SQL0),0,"total");

                if ( $MI_CONT>0 ){
                    print display_message("J&aacute; existe(m) ".$MI_CONT." livro(s) com mesmo ISBN; inclu&iacute;ndo como nova c&oacute;pia.");
                    $LV_COPI=$MI_CONT+1;
                } else {
                    $LV_COPI=1;
                }

                $DB_SQL1="INSERT INTO tb_livros (".
                " tx_titulo_livro, tx_autor_livro, tx_isbn_livro,".
                " tx_class_livro, tx_pha_livro, tx_editora_livro,".
                " tx_cidade_livro, tx_uf_livro, tx_ed_livro, ".
                " tx_vol_livro, tx_pat_livro, tx_pag_livro,".
                " tx_ano_livro, nm_copia_livro, tx_cip_livro,".
                " tx_assunto_livro ) VALUES (".
                format_in_quotes(array($LV_TITL,$LV_AUTO,$LV_ISBN,
                $LV_CLAS,$LV_PHAL,$LV_EDIT,$LV_CIDA,$LV_UNFE,
                $LV_EDIC,$LV_VOLU,$LV_PATR,$LV_PAGS,$LV_ANOL,
                $LV_COPI,$LV_CIPL,$LV_ASSU)).")";

                if ( db_query($DB,$DB_DATA,$DB_SQL1) ){
                    print display_message("Registro Inserido");
                }  else {
                    print display_error($DB_ERRO,$DB_SQL1);
                    $MI_ACTN=-1;
                }
            }
        } else {
            $LV_TITL="";
            $LV_AUTO="";
            $LV_ISBN="";
            $LV_CLAS="";
            $LV_PHAL="";
            $LV_EDIT="";
            $LV_CIDA="";
            $LV_UNFE="--";
            $LV_EDIC="";
            $LV_VOLU="";
            $LV_PATR="";
            $LV_PAGS="";
            $LV_ANOL="";
            $LV_CIPL="";
            $LV_ASSU="";
            include("formulario_livro.php");
        }
        break;

        case 2:
        // Exibição
        $DB_BASE="SELECT".
        " tx_titulo_livro, tx_autor_livro, tx_isbn_livro,".
        " tx_class_livro, tx_pha_livro, tx_editora_livro,".
        " tx_cidade_livro, tx_uf_livro, tx_ed_livro,".
        " tx_vol_livro, tx_pat_livro, tx_pag_livro,".
        " tx_ano_livro, nm_copia_livro, tx_cip_livro,".
        " tx_assunto_livro ".
        "FROM tb_livros ".
        "WHERE id_livro=\"".$MI_REGI."\" ".
        "LIMIT 1";

        $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

        $DB_CONT=db_num_rows($DB_SQL0);

        if ( $DB_CONT==1 ){
            print "<div class='modulo'>Registro #".$MI_REGI."</div>\n".
            "<br/>\n";

            $DB_LINE=db_fetch_array($DB_SQL0);

            list( $LV_TITL, $LV_AUTO, $LV_ISBN, $LV_CLAS,
            $LV_PHAL, $LV_EDIT, $LV_CIDA, $LV_UNFE,
            $LV_EDIC, $LV_VOLU, $LV_PATR, $LV_PAGS,
            $LV_ANOL, $LV_COPI, $LV_CIPL, $LV_ASSU
            ) = $DB_LINE;

            if ( $MI_EDIT>0 ){
                if ( $MI_SEGV>0 ){
                    $LV_TITL=$_POST['form_titl'];
                    $LV_AUTO=$_POST['form_auto'];
                    $LV_ISBN=$_POST['form_isbn'];
                    $LV_CLAS=$_POST['form_clas'];
                    $LV_PHAL=$_POST['form_phal'];
                    $LV_EDIT=$_POST['form_edit'];
                    $LV_CIDA=$_POST['form_cida'];
                    $LV_UNFE=$_POST['form_unfe'];
                    $LV_EDIC=$_POST['form_edic'];
                    $LV_VOLU=$_POST['form_volu'];
                    $LV_PATR=$_POST['form_patr'];
                    $LV_PAGS=$_POST['form_pags'];
                    $LV_ANOL=$_POST['form_anol'];
                    $LV_CIPL=$_POST['form_cipl'];
                    $LV_ASSU=$_POST['form_assu'];

                    $MI_ERRO="";
                    include("verifica_livro.php");

                    if ( strlen($MI_ERRO)>0 ){
                        print display_error("VERIFIQUE OS DADOS DIGITADOS",$MI_ERRO)."<br/>\n";
                        include("formulario_livro.php");
                    } else {
                        $DB_BASE="UPDATE tb_livros SET ".
                        format_in_equals(array(
                        "tx_titulo_livro","tx_autor_livro","tx_isbn_livro",
                        "tx_class_livro","tx_pha_livro","tx_editora_livro",
                        "tx_cidade_livro","tx_uf_livro","tx_ed_livro",
                        "tx_vol_livro","tx_pat_livro","tx_pag_livro",
                        "tx_ano_livro","nm_copia_livro","tx_cip_livro",
                        "tx_assunto_livro"),array(
                        $LV_TITL,$LV_AUTO,$LV_ISBN,$LV_CLAS,$LV_PHAL,
                        $LV_EDIT,$LV_CIDA,$LV_UNFE,$LV_EDIC,$LV_VOLU,
                        $LV_PATR,$LV_PAGS,$LV_ANOL,$LV_COPI,$LV_CIPL,
                        $LV_ASSU
                        ))." ".
                        "WHERE id_livro=\"".$MI_REGI."\" ".
                        "LIMIT 1";

                        $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                        if ( $DB_SQL0 ){
                            print display_message("Registro #".$MI_REGI." alterado").
                            "<br/>\n".
                            "<div class='caixa'>\n";

                           include("ficha_livro.php");

                           print "</div>\n";
                       } else {
                           print display_error($DB_ERRO,$DB_BASE);
                           $MI_ACTN=-1;
                       }
                   }
               } else {
                   include("formulario_livro.php");
               }
            } else {
                if ( $MI_SEGV>0 ){
                    // Histórico do livro
                    print "<div class='caixa'>".
                    "<div class='titulo'>".strtoupper($LV_TITL)."</div>\n".
                    "<div class='autor'>".format_author($LV_AUTO)."</div>\n";

                    $DB_BASE="SELECT".
                    " tx_usuario_historico,".
                    " DATE_FORMAT(dt_inicio_historico,'%d/%m/%Y') ini,".
                    " DATE_FORMAT(dt_fim_historico,'%d/%m/%Y') fim,".
                    " DATE_FORMAT(dt_devol_historico,'%d/%m/%Y') dev ".
                    "FROM".
                    " tb_historicos ".
                    "WHERE".
                    " id_livro='".$MI_REGI."' ".
                    "ORDER BY".
                    " id_historico";

                    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                    if ( $DB_SQL0 ){
                        $MI_TOTAL=db_num_rows($DB_SQL0);
                        if ( $MI_TOTAL>0 ){
                            print "<table cellspacing='0px' cellpadding='0px'>\n".
                            "<tr>\n".
                            "<th width='55%'>NOME DO USU&Aacute;RIO</th>".
                            "<th width='15%'>RETIRADA</th>".
                            "<th width='15%'>DEVOLVER AT&Eacute;</th>".
                            "<th width='15%'>DEVOLU&Ccedil;&Atilde;O</th>".
                            "</tr>\n";

                            while ( $MI_LINE=db_fetch_array($DB_SQL0) ){
                                print "<tr>\n".
                                "<td>".$MI_LINE['tx_usuario_historico']."</td>".
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
                                print ">".$MI_LINE['dev']."</td></tr>\n";
                            }

                            print "</table>\n".
                            "&nbsp;Total de ".$MI_TOTAL." registro(s)<br/>\n";

                        } else {
                            print display_message("N&atilde;o existe hist&oacute;rico do livro!")."<br/>\n";
                        }
                    } else {
                        print display_error($DB_ERRO,$DB_BASE);
                    }
                    print "</div>";
                } else {
                    print "<form action=\"".
                    format_get(
                    array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR)).
                    "\" method=\"post\">\n".
                    ui_input_hidden("sv","1").
                    "<div class='caixa'>\n";

                    include("ficha_livro.php");

                    print "<div class='botao'>".
                    "<input class='botao' type=\"submit\" value=\"Historico\">".
                    "</div>";

                    print "</div>\n</form>\n";
                }
            }
        } else {
            print display_message("Registro n&atilde;o encontrado");
            $MI_ACTN=-1;
        }
        break;

        case 3:
        // Empréstimo
        print "<div class='modulo'>Empr&eacute;stimo</div>\n<br/>\n";

        if ( $MI_SEGV>0 ){
            $LV_LIVR=(int)$_POST['form_livr'];
            $LV_USER=(int)$_POST['form_user'];
            $LV_TDAY=$_POST['form_tday'];
            $LV_RETN=$_POST['form_retn'];

            $DB_SQL0="INSERT INTO tb_emprestimos (".
            " id_livro, id_usuario,".
            " dt_inicio_emprestimo,".
            " dt_fim_emprestimo ) ".
            "VALUES (".
            format_in_quotes(array($LV_LIVR,$LV_USER,$LV_TDAY,$LV_RETN)).
            ")";

            if ( db_query($DB,$DB_DATA,$DB_SQL0) ){
                print display_message("Registro Inserido");
            } else {
                print display_error($DB_ERRO,$DB_SQL0);
            }
            $MI_ACTN=-1;
        } else {
            $DB_BASE="SELECT".
            " tx_titulo_livro, tx_autor_livro ".
            "FROM tb_livros ".
            "WHERE id_livro=\"".$MI_REGI."\" ".
            "LIMIT 1";

            $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

            $DB_CONT=db_num_rows($DB_SQL0);

            if ( $DB_CONT==1 ){
                $DB_LINE=db_fetch_array($DB_SQL0);

                list( $LV_TITL, $LV_AUTO ) = $DB_LINE;

                print "<div class='caixa'>\n".
                "<div class='titulo'>".$LV_TITL."</div>\n".
                "<div class='autor'>".format_author($LV_AUTO)."</div>\n".
                "\n";

                $DB_BASE="SELECT ".
                " b.tx_nome_usuario,".
                " DATE_FORMAT(a.dt_inicio_emprestimo,'%d/%m/%y'),".
                " DATE_FORMAT(a.dt_fim_emprestimo,'%d/%m/%y') ".
                "FROM ".
                " tb_emprestimos AS a,".
                " tb_usuarios AS b ".
                "WHERE ".
                " a.id_usuario=b.id_usuario AND ".
                " a.id_livro=\"".$MI_REGI."\" ".
                "LIMIT 1";

                $DB_SQL1=db_query($DB,$DB_DATA,$DB_BASE);

                $DB_CONT=db_num_rows($DB_SQL1);

                if ($DB_CONT==1 ){
                    $DB_LINE=db_fetch_array($DB_SQL1);

                    print "\n".
                    display_message("Emprestado a ".$DB_LINE[0].", ".
        	        "de ".$DB_LINE[1]." at&eacute; ".$DB_LINE[2]);

                    $MI_ACTN=-1;
                } else {
                    $LETRAS=array( "","TODOS","9","A","B","C","D","E","F","G","H","I",
                    "J","K","L","M","N","O","P","Q","R","S","T","U","V",
                    "W","X","Y","Z");

                    print "<div class='letra'>\n";

                    for ( $I=1; $I<count($LETRAS); $I++ ){
                        if ( $I==$MI_EDIT ){
                            print "<span class='letra'>".$LETRAS[$I]."</span>";
                        } else {
                            print "<a href=\"".format_get(array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$I,$MI_SORT)).
                            "\"><span class='letra'>".$LETRAS[$I]."</span></a>";
                        }

                        if ( $I<28 ){
                            print " ";
                        }
                    }
                    print "\n</div>\n";

                    $DB_BASE="SELECT".
                    " id_usuario,".
                    " tx_nome_usuario,".
                    " st_status_usuario ".
                    "FROM".
                    " tb_usuarios ";

                    if ( $MI_EDIT>2 ){
                        $DB_BASE=$DB_BASE." WHERE LEFT(tx_nome_usuario,1)=\"".$MI_LBAR[$MI_EDIT]."\"";
                    } elseif ( $MI_EDIT==2 ){
                        $DB_BASE=$DB_BASE.
                        " WHERE LEFT(tx_nome_usuario,1) BETWEEN \"0\" AND \"9\"";
                    }

                    if ( $MI_EDIT>0 ){
                        $DB_SQL2=db_query($DB,$DB_DATA,$DB_BASE." ORDER BY tx_nome_usuario");
                        if ( db_num_rows($DB_SQL2) > 0 ){
                            $J=0;
                            $I=1;
                            print "<form action=\"".format_get(
                            array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR)).
                            "\" method=\"post\">\n".
                            "<br/>\n".
                            "<div class='caixa'>".
                            "<b>Emprestar para:</b><br/>\n";

                            print ui_input_hidden("sv","1");

                            print ui_input_hidden("form_livr",$MI_REGI);

                            while ( $MI_LINE=db_fetch_array($DB_SQL2) ){
                                print "<div class='";

                                if ( $I<1 ) {
                                    print "linha_par'>\n";
                                } else {
                                    print "linha_impar'>\n";
                                }

                                if ( strcmp($MI_LINE[2],"B")==0 ){
                                    print "<input type=\"radio\" disabled> <span class='atencao'>B</span>";
                                } else {
                                    print "<input type=\"radio\" name=\"form_user\" value=\"".$MI_LINE[0]."\"";

                                    if ( $J==0 ) {
                                        print " checked";
                                        $J++;
                                    }
        	                        print "/>";
    	                       }
                               print " ".$MI_LINE[1]."</div>\n";

                               $I=$I*-1;
                           }

                           if ( $J>0 ){
                               $MI_NULL=time();
                               $MI_TDAY=array(date("d/m/Y",$MI_NULL),date("Y-m-d",$MI_NULL));
                               $MI_NULL=$MI_NULL+$MI_DAYS*86400;
                               $MI_RETN=array(date("d/m/Y",$MI_NULL),date("Y-m-d",$MI_NULL));
                               print ui_input_hidden("form_tday",$MI_TDAY[1]);
                               print ui_input_hidden("form_retn",$MI_RETN[1]);

                               print "<br/>\n".
                               "Sendo emprestado hoje (<b>".$MI_TDAY[0]."</b>) e ".
                               "devolvido at&eacute; o dia <b>".$MI_RETN[0]."</b>.".
                               "<br/>\n";

                               print "<br/>\n".
                               "<div class='botao'>".
                               "<input class='botao' type=\"submit\" value=\"Salvar\"></div>\n";
                           }

                           print "</div>\n".
                           "</form>\n";
                       } else {
                           print display_message("N&atilde;o existem usu&aacute;rios em &quot;".$MI_LBAR[$MI_EDIT]."&quot;");
                       }
                   } else {
                        print display_message("Selecione a letra inicial do nome ".
                        "do usu&aacute;rio, &quot;9&quot; para os<br/>que ".
                        "come&ccedil;arem com n&uacute;meros ou &quot;*&quot; ".
                        "para todos.");
                    }
                }
            } else {
                print display_message("Registro n&atilde;o encontrado");
                $MI_ACTN=-1;
            }
            print "</div>\n";
        }
        break;

        case 4:
        // Remoção
        $DB_BASE="SELECT".
        " tx_titulo_livro ".
        "FROM tb_livros ".
        "WHERE id_livro=\"".$MI_REGI."\" ".
        "LIMIT 1";

        $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

        $DB_CONT=db_num_rows($DB_SQL0);

        if ( $DB_CONT==1 ){
            print "<div class='modulo'>Registro #".$MI_REGI."</div>\n<br/>\n";

            $DB_LINE=db_fetch_array($DB_SQL0);

            $US_NOME=$DB_LINE['tx_titulo_livro'];

            if ( $MI_SEGV>0 ){
            // Não posso remover um livro enquanto ele estiver emprestado
                $DB_BASE="SELECT".
                " id_emprestimo ".
                "FROM".
                " tb_emprestimos ".
                "WHERE".
                " id_livro=\"".$MI_REGI."\" ".
                "LIMIT 1";

                $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                $DB_CONT=db_num_rows($DB_SQL0);

                if ( $DB_CONT>0 ){
                    print "<div class='aviso'>O livro encontra-se emprestado!</div>\n";
                    $MI_ACTN=-1;
                } else {
                    $DB_BASE="UPDATE tb_livros SET ".
                    format_in_equals(
                    array("st_status_livro"),
                    array("D"))." ".
                    "WHERE id_livro=\"".$MI_REGI."\" ".
                    "LIMIT 1";

                    $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                    if ( $DB_SQL0 ) {
                        print display_message("Registro #".$MI_REGI." Apagado");
                        $MI_ACTN=1;
                    } else {
                        print display_error($DB_ERRO,$DB_BASE).
                        "<br/>\n";
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
                "Deseja realmente apagar o t&iacute;tulo<br/>\n".
                "&quot;".$US_NOME."&quot;?<br/><br/>\n".
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
        print display_message("A&ccedil;&atilde;o Inv&aacute;lida!");
        $MI_ACTN=-1;
    }

    // Submenu
    if ( $MI_ACTN==-1 ) {
        $MI_MENU=array("Retornar");
        $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)));
    } elseif ( $MI_ACTN==0 )  {
        $MI_MENU=array("Incluir");
        $MI_LINK=array(format_get(array($MI_OPTN,1,0,$MI_SORT,0,$MI_LETR)));
    } elseif ( $MI_ACTN==1 ) {
        $MI_MENU=array("Retornar","Incluir");
        $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)),(array($MI_OPTN,1,0,$MI_SORT,0,$MI_LETR)));
    } else {
        $MI_MENU=array("Retornar","Incluir","Editar","Emprestar","Apagar");
        $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)),
        format_get(array($MI_OPTN,1,0,$MI_SORT,0,$MI_LETR)),
        format_get(array($MI_OPTN,2,$MI_REGI,$MI_SORT,1,$MI_LETR)),
        format_get(array($MI_OPTN,3,$MI_REGI,$MI_SORT,0,$MI_LETR)),
        format_get(array($MI_OPTN,4,$MI_REGI,$MI_SORT,0,$MI_LETR)));
    }

    print "<br/>\n".
    "<div class='submenu'>".
    display_submenu($MI_MENU,$MI_LINK).
    "</div>";
?>
