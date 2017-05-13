** SORRY ENGLISH VERSION NOT RELEASED YET **

# Instalação

Assumindo que você tenha um pouco de pressa e vai instalar o "Estante"
em um servidor com GNU/Linux + Apache + MySQL + PHP siga as instruções
abaixo:

1. Crie o diretório onde ficará o programa (aconselho algo como
**/opt/estante/** para ficar de acordo com o FHS) e copie o conteúdo
do tarball para lá.

1. Inclua em **httpd.conf**, ou crie um arquivo separado dentro de
**./conf.d**, o seguinte:

    ```
    <Directory /var/www/estante>
        Options Indexes
        AllowOverride AuthConfig
        Order allow,deny
        Allow from all
     </Directory>
    ```

1. Crie o diretório estante debaixo de **/var/www** e copie para lá o
conteúdo do diretório **/opt/estante/html/** (versões mais novas do
Apache não seguem links simbólicos por padrão).

1. Edite o arquivo **/var/www/estante/configuracao.php** para que ele
aponte para o local exato onde o programa foi colocado, no caso em
**/opt/estante**:

    ``` php
    <?PHP
        $MI_CONF="/opt/estante/biblioteca_conf.php";
    ?>
    ```

1. Crie um usuário e configure a senha no MySQL com:

    ``` sql
    CREATE DATABASE estante;
    GRANT SELECT,INSERT,UPDATE,DELETE,CREAT,DROP ON estante.*
    TO estante@localhost IDENTIFIED BY "MINHA SENHA";
    QUIT
    ```

1. Carregue a estrutura do banco de dados com:

    ```   
        mysql -u estante -p -A estante < /opt/estante/estante.sql
    ```   

6. Configure o "Estante" com:

    ``` php
    <?PHP
        /*
        biblioteca_conf.php
        */

        /* banco de dados */
          $DB_SGBD="mysql";
          $DB_HOST="localhost";
          $DB_PORT="";
          $DB_USER="estante";
          $DB_PASS="MINHA SENHA";
          $DB_DATA="estante";

        /* localiza��o */
          $MI_LANG="pt_BR";
          $MI_LOCALE="pt_BR.iso8859-1";
          $MI_CHAR="iso-8859-1";

        /* diret�rios */
          $MI_HOME_DIR="/opt/estante";
          $MI_HTTP_DIR="/estante";
          $MI_LIBS_DIR=$MI_HOME_DIR."/rotinas";

        /* nome da biblioteca */
          $MI_NAME="Minha Biblioteca";
          $MI_SUBT="Uma breve descrição sobre a minha biblioteca";

        /* quantidade de dias do empr�stimo */
          $MI_DAYS=14;
    ?>
    ```

1. Crie um usuário e uma senha dentro do Apache:

    ```
       htpasswd -c /opt/estante/.htpasswd estante
       New password:
       Re-type new password:
       Adding password for user estante
    ```

1. Reinicie o Apache e pronto!
