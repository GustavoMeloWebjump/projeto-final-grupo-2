Para configurar as multistores na sua máquina:

Após dar pull no arquivo config.php, execute o comando 'bin/magento app:config:import'.

Depois, entre no diretório '/etc/apache2/sites-enabled/' e edite o arquivo '000-default.conf', adicionando o conteúdo do arquivo homônimo que está aqui nesta pasta.

Recarregue o apache com 'sudo systemctl restart apache2.service'.

bin/magento setup:install \
  --base-url=http://localhost/ \
  --db-host=localhost \
  --db-name=projetofinal \
  --db-user=projeto \
  --db-password=123456789 \
  --admin-firstname=Lincoln \
  --admin-lastname=Souza \
  --admin-email=lincoln.souza@webjump.com.br \
  --admin-user=admin \
  --admin-password=admin123 \
  --language=pt_BR \
  --currency=BRL \
  --timezone=America/Sao_Paulo \
  --use-rewrites=1 \
  --backend-frontname="admin"
  --cleanup-database