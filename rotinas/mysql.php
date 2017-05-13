<?php
/*
    MYSQL
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

function db_connect($HOST,$USER,$PASS){
    $MYSQL=mysql_connect($HOST,$USER,$PASS);

    if ( $MYSQL ){
        return $MYSQL;
    } else {
        return FALSE;
    }
}

function db_close(){
    $MYSQL=mysql_close();

    if ( $MYSQL ){
        return $MYSQL;
    } else {
        return FALSE;
    }
}

function db_select($HOST,$USER,$PASS,$DATABASE){
    if ( db_connect($HOST,$USER,$PASS) ){
        $MYSQL=mysql_select_db($DATABASE);

        if ( $MYSQL ){
            return $MYSQL;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}

function db_query($SERVER,$DATABASE,$QUERY){
    if ( db_select($SERVER[0],$SERVER[1],$SERVER[2],$DATABASE) ){
        return mysql_query($QUERY);
    } else {
        return FALSE;
    }
}

function db_num_rows($RESULT){
    return mysql_num_rows($RESULT);
}

function db_result($RESULT,$ROW,$FIELD){
    if ( strlen($FIELD)==0 ){
        return mysql_result($RESULT,$ROW);
    } else {
        return mysql_result($RESULT,$ROW,$FIELD);
    }
}

function db_fetch_array($RESULT){
    return mysql_fetch_array($RESULT);
}

function db_free_result($RESULT){
    return mysql_free_result($RESULT);
}

/* MSX RULEZ! */
?>
