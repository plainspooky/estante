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
     N�o se esque�a de colocar a senha!
   */
   $DB_PASS="";
   $DB_DATA="estante";
   
/* localização */
   $MI_LANG="pt_BR";
   $MI_LOCALE="pt_BR.iso8859-1";
   $MI_CHAR="iso-8859-1";
   
/* diretórios */
   $MI_HOME_DIR="/opt/estante";
   $MI_HTTP_DIR="/estante";
   $MI_LIBS_DIR=$MI_HOME_DIR."/rotinas";

/* nome da biblioteca */
   $MI_NAME="Minha Biblioteca";
   $MI_SUBT="Exemplo de uso do Estante vers&atilde;o 0.1";
   /*
     14 dias � uma sugest�o, mude se assim desejar
   */
   $MI_DAYS=14;
?>
