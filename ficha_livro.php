<?php

  /*
  ficha com as informações do livro
  */
  print "<div class='titulo'>".strtoupper($LV_TITL)."<br/>".$LV_SBTL."</div>\n".
	"<div class='autor'>".format_author($LV_AUTO)."</div>\n";
	
  print "<div class='caixa'>".
	$LV_EDIT.", ".$LV_ANOL."<br/>\n".
	$LV_CIDA." ".$LV_UNFE."<br/>";

  if ( $LV_EDIC>0 )
  {
    print $LV_EDIC."&ordf; Edi&ccedil;&atilde;o<br/>\n";
  }
  
  if ( $LV_VOLU>0 )
  {
    print "Volume: ".$LV_VOLU."<br/>\n";
  }
	
  print "<br/>\n".
        "ISBN: ".$LV_ISBN."<br/>\n".
	"</div>\n".
	"<br/>\n";

  print "<div class='caixa'><u>CIP</u>:<br/>".
        nl2br($LV_CIPL)."</div>\n".
	"<br/>";

  print "<div class='caixa'><u>Palavras-Chave</u>:<br/>".
        nl2br($LV_ASSU)."</div>\n".
	"<br/>";
?>
