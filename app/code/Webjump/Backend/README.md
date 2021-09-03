Para configurar as categorias e os métodos de pagamento usando o módulo:

PRIMEIRAMENTE aplique as alterações do config.php, caso não já tenha feito, com 'app:config:import'.

Execute o 'setup:upgrade' e os dados devem ser atualizados automaticamente.

Obs: caso já tenha executado esse módulo e precise executar novamente:

Antes de rodar o setup:upgrade, execute no terminal 'mysql -u projeto -p'.

Com o MySQL aberto, execute: 

use projetofinal;
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE catalog_category_entity;
TRUNCATE TABLE catalog_category_entity_datetime;
TRUNCATE TABLE catalog_category_entity_decimal;
TRUNCATE TABLE catalog_category_entity_int;
TRUNCATE TABLE catalog_category_entity_text;
TRUNCATE TABLE catalog_category_entity_varchar;
TRUNCATE TABLE catalog_category_product;
TRUNCATE TABLE catalog_category_product_index;
INSERT INTO `catalog_category_entity` (`entity_id`, `attribute_set_id`, `parent_id`, `created_at`, `updated_at`, `path`, `position`, `level`, `children_count`) VALUES ('1', '0', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1', '0', '0', '1'),
                                                                                                                                                                       ('2', '3', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1/2', '1', '1', '0');
INSERT INTO `catalog_category_entity_int` (`value_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
                                                                                                             ('1', '69', '0', '1', '1'),
                                                                                                             ('2', '46', '0', '2', '1'),
                                                                                                             ('3', '69', '0', '2', '1');
INSERT INTO `catalog_category_entity_varchar` (`value_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
                                                                                                                 ('1', '45', '0', '1', 'Root Catalog'),
                                                                                                                 ('2', '45', '0', '2', 'Default Category');
SET FOREIGN_KEY_CHECKS = 1;
DELETE FROM url_rewrite WHERE entity_type = 'category';

Este código irá resetar as categorias previamente instaladas.

Selecione então o conteúdo do patch_list ('SELECT * FROM patch_list') e apague os patches 'Install Categories' e 'Translate Categories' (se houver). Execute novamente o setup:upgrade.