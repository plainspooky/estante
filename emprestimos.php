<?php
/*
    ESTANTE
    Controle do acervo, empréstimos e usuários em uma pequena biblioteca.
    versão 0.1a

    Empréstimos (módulo)

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

    $EM_BLOC="Bloquear";
    $EM_DEVO="Devolver";

    switch ( $MI_ACTN ){
        case 0:
        // Visualização
        print "<div class='modulo'>Empr&eacute;stimos</div>\n";

        $DB_SORT=array(
            "id_emprestimo",
            "tx_titulo_livro",
            "tx_nome_usuario",
            "dt_inicio_emprestimo",
            "dt_fim_emprestimo" );

        if ( $MI_SORT<0 or $MI_SORT>=count($DB_SORT) ){
            $MI_SORT=0;
        }

        print show_letterbar($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR);

        $MI_TDAY=date("Y-m-d",time());

        $DB_BASE="SELECT a.id_emprestimo,".
            " b.tx_titulo_livro,".
            " c.tx_nome_usuario,".
        /*
            " concat(c.tx_nome_usuario,".
            " IF(c.st_status_usuario='B',".
            "\"&nbsp;<span class='atencao'>B</span>\"".
            ",'')),".
        */
            " DATE_FORMAT(a.dt_inicio_emprestimo,'%d/%m/%y'),".
            " IF(a.dt_fim_emprestimo < '".$MI_TDAY."',".
            " CONCAT(DATE_FORMAT(a.dt_fim_emprestimo,'%d/%m/%y'),".
            "\"&nbsp;<span class='atencao'>!</span>\"),".
            " DATE_FORMAT(a.dt_fim_emprestimo,'%d/%m/%y')) ".
            "FROM ".
            " tb_emprestimos AS a,".
            " tb_livros AS b,".
            " tb_usuarios AS c ".
            "WHERE ".
            " a.id_livro=b.id_livro AND a.id_usuario=c.id_usuario ";

        if ( $MI_LETR>2 ){
            $DB_BASE=$DB_BASE." AND LEFT(b.tx_titulo_livro,1)=\"".$MI_LBAR[$MI_LETR]."\"";
        } elseif ( $MI_LETR==2 ) {
            $DB_BASE=$DB_BASE." AND LEFT(tx_titulo_livro,1) BETWEEN \"0\" AND \"9\"";
        }

        if ( $MI_EDIT==1 ){
            $MI_TDAY=date("Y-m-d",time());
            $DB_BASE=$DB_BASE." AND a.dt_fim_emprestimo<\"".$MI_TDAY."\"";
        }

         if ( $MI_LETR>0 ){
            $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE.
                " ORDER BY ".$DB_SORT[$MI_SORT]);

            if ( $DB_SQL0 ){
                if ( db_num_rows($DB_SQL0) > 0 ){
                    print ui_grid_table(
                        array("ID","T&Iacute;TULO","USU&Aacute;RIO","RETIRADA",
                        "DEVOLU&Ccedil;&Atilde;O"),
                        $DB_SQL0,
                        "?o=".$MI_OPTN."&a=".$MI_ACTN."&i=0&e=".$MI_EDIT.
                        "&l=".$MI_LETR."&s=",
                        "?o=".$MI_OPTN."&a=1&&s=".$MI_SORT."&e=".$MI_EDIT.
                        "&l=".$MI_LETR."&i=",
                        array("5%","40%","35%","10%","10%")
                    );
                } else {
                    print display_message("N&atilde;o existem livros emprestados em &quot;".$MI_LBAR[$MI_LETR]."&quot;");
                }
            } else {
                print display_error($DB_ERRO,$DB_BASE);
            }
        } else {
            print display_message("Selecione a letra inicial do t&iacute;tulo ".
                "do livro, &quot;9&quot; para os<br/>que ".
                "come&ccedil;arem com n&uacute;meros ou &quot;TODOS&quot; ".
                "para todos.");
            }
        break;

        case 1:
        print "<div class='modulo'>Registro #".$MI_REGI."</div>\n<br/>\n";

        if ( $MI_SEGV>0 ){
            $EM_EMPR=$_POST['form_empr'];

            switch($EM_EMPR){
                case $EM_BLOC:
                $EM_IDUS=(int)$_POST['form_idus'];

                $DB_BASE="UPDATE tb_usuarios SET ".
                    format_in_equals(
                    array("st_status_usuario"),
                    array("B"))." ".
                    "WHERE id_usuario=\"".$EM_IDUS."\" ".
                    "LIMIT 1";

                $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                if ( $DB_SQL0 ){
                    print display_message("O usu&aacute;rio #".$EM_IDUS." foi bloqueado.");
                } else {
                    print display_error($DB_ERRO,$DB_BASE);
                }
                break;

                case $EM_DEVO:
                $EM_IDEM=(int)$_POST['form_idem'];
                $DB_BASE="SELECT id_emprestimo FROM tb_emprestimos ".
                    "WHERE id_emprestimo='".$EM_IDEM."' LIMIT 1";

                $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

                if ( $DB_SQL0 ){
                    if ( db_num_rows($DB_SQL0)>0 ){
                        $DB_BASE="SELECT a.id_emprestimo,".
                            " b.id_livro,".
                            " c.id_usuario,".
                            " c.tx_nome_usuario,".
                            " c.st_status_usuario,".
                            " a.dt_inicio_emprestimo,".
                            " a.dt_fim_emprestimo ".
                            "FROM ".
                            " tb_emprestimos AS a,".
                            " tb_livros AS b,".
                            " tb_usuarios AS c ".
                            "WHERE ".
                            " a.id_livro=b.id_livro AND".
                            " a.id_usuario=c.id_usuario AND".
                            " a.id_emprestimo='".$EM_IDEM."' ".
                            "LIMIT 1";

                        $DB_SQL1=db_query($DB,$DB_DATA,$DB_BASE);

                        if ( $DB_SQL1 ){
                            $MI_TDAY=date("Y-m-d",time());
                            $MI_LINH=db_fetch_array($DB_SQL1);
                            $DB_BASE="INSERT INTO tb_historicos (".
                                " id_livro, id_usuario, tx_usuario_historico,".
                                " dt_inicio_historico, dt_fim_historico,".
                                " dt_devol_historico) ".
                                "VALUES (".
                                format_in_quotes(array(
                                    $MI_LINH['id_livro'],
                                    $MI_LINH['id_usuario'],
                                    $MI_LINH['tx_nome_usuario'],
                                    $MI_LINH['dt_inicio_emprestimo'],
                                    $MI_LINH['dt_fim_emprestimo'],
                                    $MI_TDAY)).")";

                            $DB_SQL2=db_query($DB,$DB_DATA,$DB_BASE);

                            $DB_BASE="DELETE FROM tb_emprestimos ".
                                "WHERE id_emprestimo='".$EM_IDEM."' ".
                                "LIMIT 1";

                            $DB_SQL3=db_query($DB,$DB_DATA,$DB_BASE);

                            if ( $DB_SQL2 and $DB_SQL3 ){
                                print display_message("Livro Devolvido");
                            } else {
                                print display_error($DB_ERRO,$DB_BASE);
                            }
                        } else {
                            print display_error($DB_ERRO,$DB_BASE);
                        }
                    } else {
                        print display_message("Registro Inv&aacute;lido");
                    }
                } else {
                    print display_error($DB_ERRO,$DB_BASE)
                }
                break;

                default:
                print display_message("Op&ccedil;&atilde;o Inv&aacute;lida");
            }
            $MI_ACTN=-1;
        } else {
            $MI_TDAY=date("Y-m-d",time());

            $DB_BASE="SELECT a.id_emprestimo,".
                " b.tx_titulo_livro,".
                " b.tx_autor_livro,".
                " c.id_usuario,".
                " c.tx_nome_usuario,".
                " c.st_status_usuario,".
                " DATE_FORMAT(a.dt_inicio_emprestimo,'%d/%m/%y') AS inicio,".
                " DATE_FORMAT(a.dt_fim_emprestimo,'%d/%m/%y') AS fim, ".
                " IF(a.dt_fim_emprestimo<'".$MI_TDAY."',1,0) AS situacao ".
                "FROM ".
                " tb_emprestimos AS a,".
                " tb_livros AS b,".
                " tb_usuarios AS c ".
                "WHERE ".
                " a.id_livro=b.id_livro AND".
                " a.id_usuario=c.id_usuario AND".
                " a.id_emprestimo='".$MI_REGI."' ".
                "LIMIT 1";

            $DB_SQL0=db_query($DB,$DB_DATA,$DB_BASE);

            if ( $DB_SQL0 ){
                if ( db_num_rows($DB_SQL0) > 0 ){
                    $MI_LINH=db_fetch_array($DB_SQL0);

                    print "<div class='caixa'>\n".
                        "<div class='titulo'>".$MI_LINH['tx_titulo_livro']."</div>\n".
                        "<div class='autor'>".
                        format_author($MI_LINH['tx_autor_livro']).
                        "</div>\n".
                        "Emprestado para ".$MI_LINH['tx_nome_usuario']." de ".
                        print "<form action=\"".
                        $MI_LINH['inicio']." at&eacute; ".$MI_LINH['fim'].".<br/>\n";

                        format_get(
                        array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR)).
                        "\" method=\"post\">\n";

                    print ui_input_hidden("sv","1");

                    print ui_input_hidden("form_idus",$MI_LINH['id_usuario']);

                    print ui_input_hidden("form_idem",$MI_LINH['id_emprestimo']);

                    if ( $MI_LINH['situacao']==1 ){
                        print "<br/>\n".
                            "<div class='atencao'>LIVRO EM ATRASO!</div>\n".
                            "<br/>\n".
                            "<div class='botao'>";

                            if ( strcmp($MI_LINH['st_status_usuario'],"A")==0 ){
                                print "<input class='botao' type='submit' name='form_empr'".
                                " value='".$EM_BLOC."'/> &nbsp;";
                            }
                            } else {
                                print "<div class='botao'>";
                            }

                    print "<input class='botao' type='submit' name='form_empr'".
                        " value='".$EM_DEVO."'\>".
                        "</div>\n";

                        print "</form>\n".
                        "</div>\n";
                } else {
                    print display_message("Registro n&atilde;o encontrado");
                }
            } else {
                print display_error($DB_ERRO,$DB_BASE);
            }
        }
        break;

        case 3:
            print "<div class='modulo'>Devolu&ccedil;&atilde;o</div>\n".
                    "<br/>\n";
        break;

        default:
        print display_message("A&ccedil;&atilde;o Inv&aacute;lida");
        $MI_ACTN=-1;
    }

    // Submenu
    if ( $MI_ACTN==-1 ){
        $MI_MENU=array("Retornar");
        $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,$MI_EDIT,$MI_LETR)));
    } elseif ( $MI_ACTN==0 ){
        if ( $MI_EDIT==0 ){
            $MI_MENU=array("Mostrar Atrasados");
            $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,1,$MI_LETR)));
        } else {
            $MI_MENU=array("Mostrar Todos");
            $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)));
        }
    } else {
        $MI_MENU=array("Retornar");
        $MI_LINK=array(format_get(array($MI_OPTN,0,0,$MI_SORT,0,$MI_LETR)));
    }

    print "<br/>\n".
        "<div class='submenu'>".
        display_submenu($MI_MENU,$MI_LINK).
        "</div>";
?>
