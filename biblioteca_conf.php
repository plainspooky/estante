<?PHP
/*
  biblioteca_conf.php
*/

/* banco de dados */
   $DB_SGBD="mysql";
   $DB_HOST="localhost";
   $DB_PORT="";
   $DB_USER="estante";
   /*
     Não se esqueça de colocar a senha!
   */
   $DB_PASS="";
   $DB_DATA="estante";
   
/* localizaÃ§Ã£o */
   $MI_LANG="pt_BR";
   $MI_LOCALE="pt_BR.iso8859-1";
   $MI_CHAR="iso-8859-1";
   
/* diretÃ³rios */
   $MI_HOME_DIR="/opt/estante";
   $MI_HTTP_DIR="/estante";
   $MI_LIBS_DIR=$MI_HOME_DIR."/rotinas";

/* nome da biblioteca */
   $MI_NAME="Minha Biblioteca";
   $MI_SUBT="Exemplo de uso do Estante vers&atilde;o 0.1";
   /*
     14 dias é uma sugestão, mude se assim desejar
   */
   $MI_DAYS=14;
?>
