para rodar esse datapatch, é necessario:

- entrar na pasta raiz do projeto dentro do terminal
- execute o seguinte comando: bin/magento module:enable Webjump_Backend
- execute bin/magento cache:flush
- execute bin/magento setup:di:compile
- apos isso, rode: bin/magento setup:upgrade

para validar:

- abra o admin, entre na area marketing e busque "catalog price rule" e tire print da regra de catalogo definida (pode acessa-la e tirar print dela tambem)

- abra o admin, entre na area marketing e busque "cart price rule" e tire print da regra de catalogo definida (pode acessa-la e tirar print dela tambem)
