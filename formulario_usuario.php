<?php
/*
    Formulário para a inclusão/alteração de usuários
*/
    print "<form action=\"".
        format_get(
        array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR)).
        "\" method=\"post\">\n";

    print "<div class='caixa'>\n";

    print ui_input_hidden("sv","1");

    print "<table>";

    print "<tr><td width='20%'>".
        ui_input("Nome</td><td>","form_nome",48,$US_NOME).
        "</td></tr>\n";

    print "<tr><td>".
        ui_input("Documento</td><td>","form_docu",16,$US_DOCU).
        "</td></tr>\n";

    print "<tr><td>".
        ui_input_multiple("Data de Nascimento</td><td>"," / ",
        array("form_dian","form_mesn","form_anon"),
        array(2,2,4),
        array($US_DIAN,$US_MESN,$US_ANON)).
        "</td</tr>\n";

    print "<tr><td>".
        ui_combo_box_str("Sexo</td><td>","form_sexo",$US_SEXO,array("M","F")).
        "( M : Masculino, F : Feminino )".
        "</td></tr>\n";

    print "<tr><td>".
        ui_combo_box("Escolaridade</td><td>","form_esco",$US_ESCO,$MI_ESCO).
        "</td></tr>\n";

    print "<tr><td>".
        ui_input("Telefone Residencial</td><td>","form_tres",16,$US_TRES).
        "</td></tr>\n";

    print "<tr><td>".
        ui_input("Telefone Celular</td><td>","form_tcel",16,$US_TCEL).
        "</td></tr>\n";

    print "<tr><td>".
        ui_input("Telefone Comercial</td><td>","form_tcom",16,$US_TCOM).
        "</td></tr>\n";

    print "<tr><td>".
        ui_combo_box_str("Situa&ccedil;&atilde;o</td><td>",
        "form_stat",$US_STAT,array("A","B")).
        "( A : Ativo, B : Bloqueado )".
        "</td></r>\n";

    print "</table>";

    print "<div class='botao'>".
        "<input class='botao' type=\"submit\" value=\"Salvar\">".
        "</div>\n";

    print "</div>\n".
        "</form>\n";
?>
