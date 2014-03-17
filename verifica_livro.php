<?php
/*
  verificação/validação dos dados digitados em "formulario_livro.php"
*/

  // Título
  if ( strlen($LV_TITL)==0 )
  {
    $MI_ERRO=$MI_ERRO."Digite o t&iacute;tulo do livro!<br/>\n";
  }
  else
  {
    $LV_TITL=strtoupper(substr($LV_TITL,0,192));;
  }

  // Autor(es) 
  if ( strlen($LV_AUTO)==0 )
  {
    $MI_ERRO=$MI_ERRO."Digite o(s) nome(s) do(s) autor(es)!<br/>\n";
  }
  else
  {
    $LV_AUTO=substr($LV_AUTO,0,128);
  }

  // ISBN
  if ( strlen($LV_ISBN)!=10 )
  {
    $MI_ERRO=$MI_ERRO."O ISBN deve possuir 10 caracteres!<br/>\n";
  }
  else
  {
    $LV_ISBN=strtoupper($LV_ISBN);
  }

  // Classificação
  if ( strlen($LV_CLAS)==0 )
  {
    $MI_ERRO=$MI_ERRO."Digite a classifica&ccedil;&atilde;o do livro!<br/>\n";
  }
  else
  {
    $LV_CLAS=substr($LV_CLAS,0,32);
  }

  // PHA
  if ( strlen($LV_PHAL)==0 )
  {
    $MI_ERRO=$MI_ERRO."Digite o PHA do livro!<br/>\n";
  }
  else
  {
    $LV_PHAL=substr($LV_PHAL,0,6);
  }

  // Editora
  if ( strlen($LV_EDIT)==0 )
  {
    $MI_ERRO=$MI_ERRO."Digite o nome da editora!<br/>\n";
  }
  else
  {
    $LV_EDIT=substr($LV_EDIT,0,48);
  }

  // Cidade
  if ( strlen($LV_CIDA)==0 )
  {
    $MI_ERRO=$MI_ERRO."Digite o nome da cidade!<br/>\n";
  }
  else
  {
    $LV_CIDA=substr($LV_CIDA,0,48);
  }

  // UF
  $LV_UNFE=substr($LV_UNFE,0,2);
  
  // Ano de Publicação
  if ( strlen($LV_ANOL)==0 )
  {
    $MI_ERRO=$MI_ERRO."Digite o ano de publica&ccedil;&atilde;o!<br/>\n";
  }
  else
  {
    $LV_ANOL=substr($LV_ANOL,0,4);
  }

  // Opcionais
  $LV_EDIC=(int)$LV_EDIC;
  $LV_VOLU=(int)$LV_VOLU;
  $LV_PAGS=(int)$LV_PAGS;
  $LV_PATR=substr($LV_PATR,0,8);
  $LV_CIPL=substr($LV_CIPL,0,4096);
  $LV_ASSU=substr($LV_ASSU,0,255);
?>
