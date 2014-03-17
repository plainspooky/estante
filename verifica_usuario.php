<?php
/*
  verificação/validação dos dados digitados em "formulario_usuario.php"
*/
  
  /*
  nome
  */
  if ( strlen($US_NOME)>0 )
  {
    $US_NOME=strtoupper(substr($US_NOME,0,48));
  }
  else
  {
    $MI_ERRO=$MI_ERRO."Digite o Nome!<br/>\n";
  }

  /*
  documento
  */
  if ( strlen($US_NOME)>0 )
  {
    $US_DOCU=strtoupper(substr($US_DOCU,0,16));
  }
  else
  {
    $MI_ERRO=$MI_ERRO."Digite um n&uacute;mero de documento!<br/>\n";
  }
  
  /*
  data de nascimento
  */
  if (! validate_please("DAT",
                        $US_DIAN."-".$US_MESN."-".$US_ANON,
			array("DMY","-")) )
  {
    $MI_ERRO=$MI_ERRO."Data de Nascimento Inv&aacute;lida!<br/>\n";
  }
 
  /*
  sexo
  */
  $US_SEXO=substr($US_SEXO,0,1);
  
  /*
  status
  */
  $US_STAT=substr($US_STAT,0,1);

  /*
  escolaridade
  */
  if (! validate_please("NUM",$US_ESCO,array(1,1,count($MI_ESCO))) )
  {
    $MI_ERRO=$MI_ERRO."Escolaridade Incorreta!<br/>\n";
  }
  
  /*
  Telefones são opcionais (apenas faço o corte)
  */
  $US_TRES=substr($US_TRES,0,8);
  $US_TCEL=substr($US_TCEL,0,8);
  $US_TCOM=substr($US_TCOM,0,8);
?>
