<?php
/*
    Controle de Biblioteca
    versão 0.2

    Módulo: Sobre

    Copyright (C) 2005,2017  Giovanni Nunes <bitatwork@yahoo.com>

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

    print "<div class='modulo'>Sobre o Programa...</div>\n".
        "<br/>\n".
        "<div class='caixa'>";

    print "<div class='titulo'>".$MI_PROG."</div>\n".
        "<div>".$MI_PDSC."<br/>\n".
        "Vers&atilde;o ".$MI_VERS."</div>\n".
        "<div class='autor'>Copyright &copy;2005 Giovanni Nunes</div>\n";

    print "<p class='lic'>Este programa &eacute; software livre; voc&ecirc; ".
        "pode redistribu&iacute;-lo e/ou modific&aacute;-lo sob os termos ".
        "da Licen&ccedil;a P&uacute;blica Geral GNU conforme publicada pela ".
        "Free Software Foundation; tanto a vers&atilde;o 2 da ".
        "Licen&ccedil;a, como (a seu crit&eacute;rio) qualquer vers&atilde;o ".
        "posterior.</p>\n";

    print "<p class='lic'>Este programa &eacute; distribu&iacute;do na ".
        "expectativa de que seja &uacute;til, por&eacute;m, SEM NENHUMA ".
        "GARANTIA; nem mesmo a garantia impl&iacute;cita de COMERCIABILIDADE ".
        "OU ADEQUA&Ccedil;&Atilde;O A UMA FINALIDADE ESPEC&Iacute;FICA. ".
        "Consulte a Licen&ccedil;a P&uacute;blica Geral do GNU para mais ".
        "detalhes.</p>\n";

    print "<p class='lic'>Voc&ecirc; deve ter recebido uma c&oacute;pia da ".
        "Licen&ccedil;a P&uacute;blica Geral do GNU junto com este programa; ".
        "se n&atilde;o, escreva para a Free Software Foundation, Inc., no ".
        "endere&ccedil;o: ".
        "59 Temple Street, Suite 330, Boston, MA 02111-1307 USA.</p>\n";

    print "<div style='position:right;text-align:center'>".cc_gnu_gpl()."</div>\n";

    print "</div>\n<br/>\n";
?>
