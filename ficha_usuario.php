<?php
/*
  ficha com os dados do usuário
*/
  print "<table>";

  $US_LEGE=array("Nome",
                 "Documento",
		 "Data de Nascimento",
                 "Sexo",
		 "Escolaridade",
		 "Telefone Residencial",
		 "Telefone Celular",
		 "Telefone Comercial",
		 "Situa&ccedil;&atilde;o");

  $US_VALU=array($US_NOME,
                 $US_DOCU,
		 $US_DIAN."/".$US_MESN."/".$US_ANON,
                 $US_SEXO." &nbsp; ( M : Masculino, F : Feminino )",
		 $MI_ESCO[$US_ESCO-1],
		 $US_TRES,
		 $US_TCEL,
		 $US_TCOM,
		 $US_STAT." &nbsp; ( A : Ativo, B : Bloqueado )");

  for ( $I=0; $I<count($US_LEGE); $I++ )
  {
    print "<tr>".
          "<td width='20%'>".
          "<b>".$US_LEGE[$I]."</b>".
	  "</td>".
	  "<td width='80%'>".
	  $US_VALU[$I].
	  "</td></tr>\n";
  }
  
  print "</table>";
?>
