<?PHP
/*
    biblioteca_conf.php
*/

    // Banco de dados
    $DB_SGBD="mysql";
    $DB_HOST="localhost";
    $DB_PORT="";
    $DB_USER="estante";

    // Não se esqueça de colocar a senha!
    $DB_PASS="";
    // Não se esqueça de colocar a senha!

    $DB_DATA="estante";

    // Localização
    $MI_LANG="pt_BR";
    $MI_LOCALE="pt_BR.UTF-8";
    $MI_CHAR="UTF-8";

    // Diretórios
    $MI_HOME_DIR="/opt/estante";
    $MI_HTTP_DIR="/estante";
    $MI_LIBS_DIR=$MI_HOME_DIR."/rotinas";

    // Nome da Biblioteca
    $MI_NAME="Minha Biblioteca";
    $MI_SUBT="Exemplo de uso do Estante vers&atilde;o 0.1";

    // Duração do empréstimo
    // 4 dias é uma sugestão, mude se assim desejar
    $MI_DAYS=14;
?>
