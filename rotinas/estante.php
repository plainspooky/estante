<?php
/*
    ESTANTE
    Controle do acervo, empréstimos e usuários em uma pequena biblioteca.
    versão 0.1

    Rotinas Específicas do Programa

    Copyright (C) 2005-2014  Giovanni Nunes <giovanni.nunes@gmail.com>

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

function display_submenu($ITEM,$LINK){
    $ESTANTE="";
    $J=0;

    foreach($ITEM as $I){
        $ESTANTE.="<a class='submenu' href=\"".$LINK[$J]."\">".$I."</a>";
        $J++;
    }

    return $ESTANTE;
}

function display_error($TYPE,$MESSAGE){
    return "<div class='erro'><b>".$TYPE.":</b><br/>\n".$MESSAGE."</div>\n";
}

function display_message($MESSAGE){
    return "<div class='aviso'>".$MESSAGE."</div>\n";
}

function format_in_quotes($LIST){
    $ESTANTE="";
    $J=count($LIST);

    for ( $I=0; $I<$J; $I++ ){
        $ESTANTE.="\"".$LIST[$I]."\"";
        if ( $I!=($J-1) ){
          $ESTANTE.=", ";
        }
    }

    return $ESTANTE;
}

function format_in_equals($LIST,$VALUE){
    $ESTANTE="";
    $J=count($LIST);

    for ( $I=0; $I<$J; $I++ ){
        $ESTANTE.=$LIST[$I]."=\"".$VALUE[$I]."\"";

        if ( $I!=($J-1) ){
            $ESTANTE.=", ";
        }
    }
    return $ESTANTE;
}

function validate_please($TYPE,$VAR,$ACTION){
    switch ($TYPE){
        case  "DAT":
        list($I,$J,$K)=split($ACTION[1],$VAR);
        $I=(int)$I;
        $J=(int)$J;
        $K=(int)$K;

        switch($ACTION[0]){
            case "DMY":
            return checkdate($J,$I,$K);
            case "MDY":
            return checkdate($I,$J,$K);
            case "YMD":
            return checkdate($J,$K,$I);
            default:
            return FALSE;
        }
        break;

        case "NUM";
        switch ( $ACTION[0] ){
            case 1:
            $I=(int)$VAR;
            break;
            case 2:
            $I=(float)$VAR;
            break;
            default:
            return FALSE;
        }
        if ( $I>=$ACTION[1] and $I<=$ACTION[2] ){
            return TRUE;
        } else {
            return FALSE;
        }
        break;

        default:
        return FALSE;
    }
    return FALSE;
}

function format_author($AUTHOR){
    $ESTANTE="";
    $I=split(";",$AUTHOR);

    foreach ($I as $J){
        $K=split(",",$J);
        $ESTANTE.=strtoupper($K[0]).", ".ucwords($K[1])."<br/>";
    }
    return $ESTANTE;
}

function show_letterbar($OPTN,$ACTN,$REGI,$SORT,$EDIT,$LETR)
{
    $LETTERS=array("","TODOS","9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    $ESTANTE="<div class='letra'>\n";

    for ( $I=1; $I<count($LETTERS); $I++ ){
        if ( $I==$LETR ){
            $ESTANTE.="<span class='letra'>".$LETTERS[$I]."</span>";
        } else {
            $ESTANTE.="<a href=\"".
            format_get(array($OPTN,$ACTN,$REGI,$SORT,$EDIT,$I)).
            "\"><span class='letra'>".$LETTERS[$I]."</span></a>";
        }
        if ( $I<28 ){
            $ESTANTE.=" ";
        }
    }
    return $ESTANTE."\n</div>\n";
}

function cc_gnu_gpl(){
    return "<!-- Creative Commons License -->\n".
    "<div>".
    "<a href=\"http://creativecommons.org/licenses/GPL/2.0/\">".
    "<img class='lic' alt=\"CC-GNU GPL\" border=\"0\"".
    " src=\"http://creativecommons.org/images/public/cc-GPL-a.png\"/>".
    "</a><br/><span style='font-size:8pt'>".
    "<b>Este Software &eacute; licenciado sob a <a class='lic'".
    " href=\"http://creativecommons.org/licenses/GPL/2.0/\">".
    "CC-GNU GPL</a></b></span>".
    "</div>\n".
    "<!-- /Creative Commons License -->";
}
