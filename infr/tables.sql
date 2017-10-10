--
-- Структура таблицы для хранения справочника лекарств
--
CREATE TABLE `catalog_drugs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY(`id`)
)
--
-- Структура таблицы для хранения сроков годности лекарств
--
CREATE TABLE `drugs` (
  `id` int(11) NOT NULL,
  `catalog_drug_id` int(11) NOT NULL,
  `best_before` date NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (catalog_drug_id) REFERENCES catalog_drugs(id)
)
--
-- Структура таблицы для хранения заболеваний
--
CREATE TABLE `diseases` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY(`id`)
)
--
-- Структура соединительной таблицы для реализации связи многие-ко-многим(одно и то же лекарство используется
-- для лечения многих болезней, и одну и ту же болезнь лечат несколькими лекарствами)
--
CREATE TABLE `drug_disease` (
  `catalog_drug_id` int(11) NOT NULL,
  `disease_id` int(11) NOT NULL,
  PRIMARY KEY (`drug_id`,`disease_id`),
  FOREIGN KEY (catalog_drug_id) REFERENCES catalog_drugs(id),
  FOREIGN KEY (disease_id) REFERENCES diseases(id)
)