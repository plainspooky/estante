<?php
/*
    USER INTERFACE
    versão 0.1

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

function ui_input_hidden($FIELD,$VALUE){
    return "<input type=\"hidden\" name=\"".$FIELD."\"".
    " value=\"".$VALUE."\"/>\n";
}

function ui_input_multiple($LABEL,$DIV,$NAME,$WIDTH,$VALUE){
    $UI="<b>".$LABEL."</b>\n";
    $J=count($NAME);

    for($I=0; $I<$J; $I++){
        $UI.="<input type=\"text\" name=\"".$NAME[$I]."\"".
        " size=\"".$WIDTH[$I]."\"".
        " maxlength=\"".$WIDTH[$I]."\"".
        " value=\"".$VALUE[$I]."\"/>";

        if ( $I!=($J-1) ){
            $UI.=$DIV;
        }
    }
    return $UI."\n";
}

function ui_input($LABEL,$NAME,$WIDTH,$VALUE){}
    return "<b>".$LABEL."</b>\n".
    "<input type=\"text\" name=\"".$NAME."\"".
    " size=\"".$WIDTH."\"".
    " maxlength=\"".$WIDTH."\"".
    " value=\"".$VALUE."\"".
    "\>\n";
}

function ui_textarea($LABEL,$NAME,$COLS,$ROWS,$VALUE){
    return "<b>".$LABEL."</b>\n".
    "<textarea name=\"".$NAME."\"".
    " cols=\"".$COLS."\"".
    " rows=\"".$ROWS."\ wrap=\"soft\">".
    $VALUE.
    "</textarea>\n".
    "\n";
}

function ui_combo_box_str($LABEL,$NAME,$SELECTED,$LIST){
    $UI="<b>".$LABEL."</b>\n<select name=\"".$NAME."\" style='width:4em;'>\n";
    $J=count($LIST);

    for($I=0; $I<$J; $I++){
        $UI=$UI."<option name=\"".$NAME."\" value=\"".$LIST[$I]."\"";

        if ( strcmp($LIST[$I],$SELECTED)==0 ){
        $UI=$UI." selected";
        }
        $UI=$UI.">".$LIST[$I]."</option>\n";
    }
    return $UI."</select>\n";
}

function ui_combo_box($LABEL,$NAME,$SELECTED,$LIST){
    $UI="<b>".$LABEL."</b>\n<select name=\"".$NAME."\">\n";
    $J=count($LIST);

    for($I=1; $I<=$J; $I++){
        $UI=$UI."<option name=\"".$NAME."\" value=\"".$I."\"";

        if ( $I==$SELECTED ){
            $UI=$UI." selected";
        }
        $UI=$UI.">".$LIST[$I-1]."</option>\n";
    }
    return $UI."</select>\n";
}

function ui_simple_form($LABEL,$NAME,$WIDTH,$VALUE){
    $UI="";
    $J=count($LABEL);

    for ($I=0; $I<$J; $I++){
        $UI=$UI."<p>".
        ui_input($LABEL[$I],$NAME[$I],$WIDTH[$I],$VALUE[$I])."</p>";
    }
    return $UI."\n";
}

function ui_grid_table($HEAD,$QUERY,$SORT,$EDIT,$WIDTH){
    $UI="<table cellspacing='0' cellpadding='0'>\n".
    "<tr>";
    $K=0;
    $J=count($HEAD);
    $L=db_num_rows($QUERY);
    if ( $L>0 ){
        for( $I=0; $I<$J; $I++ ){
            if ( is_array($WIDTH) ){
                $UI.="<th width='".$WIDTH[$I]."'>";
            } else {
                $UI.="<th>";
            }

            if ( strcmp($SORT,"")>0 ){
                $UI.="<a href=\"".$SORT.$I."\">".$HEAD[$I]."</a>";
            } else {
                $UI.=$HEAD[$I];
            }
            $UI.="</th>";
        }

        $UI.="</tr>\n";

        while ( $REGISTER=db_fetch_array($QUERY) ){
            $UI.="<tr>";

            for( $I=0; $I<$J; $I++ ){
                $UI.="<td>";

                if ( strcmp($EDIT,"")>0 ){
                    $UI.="<a href=\"".$EDIT.$REGISTER[0]."\">".$REGISTER[$I]."</a>";
                } else {
                    $UI.=$REGISTER[$I];
                }

                $UI.="</td>";
            }
            $K++;
            
            $UI.="</tr>\n";
        }

        $UI.="</table>\n&nbsp;Total de ".$K." registro(s)<br/>\n";
    } else {
        $UI="<div>Nenhum Registro Encontrado</div>\n";
    }
    return $UI;
}

function ui_error_msg($MENSA,$LEVEL){}
    return "<div>Erro:<br/>".$MENSA."</div>\n";
}

/* MSX RULEZ! */
?>
