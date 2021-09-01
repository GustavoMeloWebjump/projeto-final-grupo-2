Para configurar as multistores na sua máquina:

Após dar pull no arquivo config.php, execute o comando 'bin/magento app:config:import'.

Depois, entre no diretório '/etc/apache2/sites-enabled/' e edite o arquivo '000-default.conf', adicionando o conteúdo do arquivo homônimo que está aqui nesta pasta.

Recarregue o apache com 'sudo systemctl restart apache2.service'.