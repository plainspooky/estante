<?php
/*
  formulário para a inclusão/alteração de um livro
*/
  print "<form action=\"".
        format_get(
	array($MI_OPTN,$MI_ACTN,$MI_REGI,$MI_SORT,$MI_EDIT,$MI_LETR)).
        "\" method=\"post\">\n";

  print "<div class='caixa'>\n";
  
  print ui_input_hidden("sv","1");

  print "<table>\n";
  
  print "<tr><td>".
        ui_textarea("T&iacute;tulo</td><td>","form_titl",64,1,$LV_TITL).
	"</td></tr>\n";

  print "<tr><td>".
        ui_textarea("Autor(es)</td><td>","form_auto",64,1,$LV_AUTO).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("ISBN</td><td>","form_isbn",10,$LV_ISBN).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("Classifica&ccedil;&atilde;o</td><td>","form_clas",32,$LV_CLAS).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("PHA (?)</td><td>","form_phal",6,$LV_PHAL).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("Editora</td><td>","form_edit",48,$LV_EDIT).
	"</td></tr>\n";
	
  print "<tr><td>".
        ui_input("Cidade</td><td>","form_cida",48,$LV_CIDA).
	"</td></tr>\n";
  
  print "<tr><td>".ui_combo_box_str("UF</td><td>","form_unfe",$LV_UNFE,
        array("--","AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS",
	      "MT","PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC",
	      "SE","SP","TO"))."</td></tr>\n";
           
  print "<tr><td>".
        ui_input("Edi&ccedil;&atilde;o</td><td>","form_edic",3,$LV_EDIC).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("Volume</td><td>","form_volu",3,$LV_VOLU).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("N&ordm; de P&aacute;ginas</td><td>","form_pags",4,$LV_PAGS).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("Ano</td><td>","form_anol",4,$LV_ANOL).
	"</td></tr>\n";

  print "<tr><td>".
        ui_input("Patrim&ocirc;nio</td><td>","form_patr",8,$LV_PATR).
	"</td></tr>\n";

  print "<tr><td>".ui_textarea("CIP</td><td>","form_cipl",
        64,4,$LV_CIPL)."</td></tr>\n";

  print "<tr><td>".ui_textarea("Palavras-Chave</td><td>","form_assu",
        64,4,$LV_ASSU)."</td></tr>\n";

  print "</table>\n";

  print "<div class='botao'>".
	"<input class='botao' type=\"submit\" value=\"Salvar\">\n".
	"</div>\n".
	"</div>\n".
	"</form>\n";
?>
