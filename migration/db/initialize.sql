CREATE SCHEMA `shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

CREATE TABLE `shop`.`article` (
  `id` INT NOT NULL,
  `ean` VARCHAR(13) NULL,
  `title` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `price` FLOAT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `shop`.`basket_position` (
  `id` INT NOT NULL,
  `article_id` INT NULL,
  `count` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `article_id_idx` (`article_id` ASC),
  CONSTRAINT `article_id`
    FOREIGN KEY (`article_id`)
    REFERENCES `shop`.`article` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE `shop`.`basket` (
  `id` INT NOT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `shop`.`basket_position`
ADD COLUMN `basket_id` INT NULL AFTER `count`,
ADD INDEX `basket_id_idx` (`basket_id` ASC);
ALTER TABLE `shop`.`basket_position`
ADD CONSTRAINT `basket_id`
  FOREIGN KEY (`basket_id`)
  REFERENCES `shop`.`basket` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

CREATE TABLE `shop`.`order` (
  `id` INT NOT NULL,
  `basket_id` INT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `shop`.`customer` (
  `id` INT NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `shop`.`invoice_address` (
  `id` INT NOT NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `house_number` VARCHAR(45) NULL,
  `post_code` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `shop`.`invoice_address`
ADD COLUMN `customer_id` INT NULL AFTER `country`,
ADD INDEX `customer_id_idx` (`customer_id` ASC);
ALTER TABLE `shop`.`invoice_address`
ADD CONSTRAINT `customer_id`
  FOREIGN KEY (`customer_id`)
  REFERENCES `shop`.`customer` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

CREATE TABLE `shop`.`delivery_address` (
  `id` INT NOT NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `house_number` VARCHAR(45) NULL,
  `post_code` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `customer_id` INT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `shop`.`giftcard` (
  `id` INT NOT NULL,
  `code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `shop`.`voucher` (
  `id` INT NOT NULL,
  `code` VARCHAR(45) NULL,
  `reduction_monetary` DOUBLE NULL,
  `reduction_percent` DOUBLE NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `shop`.`article`
ADD COLUMN `image_path` VARCHAR(500) NULL AFTER `price`;

INSERT INTO `shop`.`article` (`title`, `description`, `price`, `image_path`) VALUES ('Refactoring: Improving the Design of Existing Code (Object Technology Series) [Englisch] [Gebundene Ausgabe]', 'Refactoring is about improving the design of existing code. It is the process of changing a software system in such a way that it does not alter the external behavior of the code, yet improves its internal structure. With refactoring you can even take a bad design and rework it into a good one. This book offers a thorough discussion of the principles of refactoring, including where to spot opportunities for refactoring, and how to set up the required tests. There is also a catalog of more than 40 proven refactorings with details as to when and why to use the refactoring, step by step instructions for implementing it, and an example illustrating how it works The book is written using Java as its principle language, but the ideas are applicable to any OO language.', '42.95', 'http://ecx.images-amazon.com/images/I/41gNhHqNwGL._BO2,204,203,200_PIsitb-sticker-arrow-click,TopRight,35,-76_SX385_SY500_CR,0,0,385,500_SH20_OU03_.jpg');
UPDATE `shop`.`article` SET `ean`='978-0201485677' WHERE `id`='0';

INSERT INTO `shop`.`article` (`id`, `ean`, `title`, `description`, `price`, `image_path`) VALUES ('1', '978-0132350884', 'Clean Code: A Handbook of Agile Software Craftsmanship (Robert C. Martin) [Englisch] [Taschenbuch]', 'Even bad code can function. But if code isn\'t clean, it can bring a development organization to its knees. Every year, countless hours and significant resources are lost because of poorly written code. But it doesn\'t have to be that way. Noted software expert Robert C. Martin presents a revolutionary paradigm with Clean Code: A Handbook of Agile Software Craftsmanship. Martin has teamed up with his colleagues from Object Mentor to distill their best agile practice of cleaning code \"on the fly\" into a book that will instill within you the values of a software craftsman and make you a better programmer-but only if you work at it. What kind of work will you be doing? You\'ll be reading code-lots of code. And you will be challenged to think about what\'s right about that code, and what\'s wrong with it. More importantly, you will be challenged to reassess your professional values and your commitment to your craft. Clean Code is divided into three parts. The first describes the principles, patterns, and practices of writing clean code. The second part consists of several case studies of increasing complexity. Each case study is an exercise in cleaning up code-of transforming a code base that has some problems into one that is sound and efficient. The third part is the payoff: a single chapter containing a list of heuristics and \"smells\" gathered while creating the case studies. The result is a knowledge base that describes the way we think when we write, read, and clean code. Readers will come away from this book understanding * How to tell the difference between good and bad code * How to write good code and how to transform bad code into good code * How to create good names, good functions, good objects, and good classes * How to format code for maximum readability * How to implement complete error handling without obscuring code logic * How to unit test and practice test-driven developmentThis book is a must for any developer, software engineer, project manager, team lead, or systems analyst with an interest in producing better code.', '32.95', 'http://ecx.images-amazon.com/images/I/41D5QxOwn9L._BO2,204,203,200_PIsitb-sticker-arrow-click,TopRight,35,-76_SX385_SY500_CR,0,0,385,500_SH20_OU03_.jpg');
INSERT INTO `shop`.`article` (`id`, `ean`, `title`, `description`, `price`, `image_path`) VALUES ('2', '978-0321146533', 'Test Driven Development. By Example (Addison-Wesley Signature) [Englisch] [Taschenbuch]', 'Quite simply, test-driven development is meant to eliminate fear in application development. While some fear is healthy (often viewed as a conscience that tells programmers to \"be careful!\"), the author believes that byproducts of fear include tentative, grumpy, and uncommunicative programmers who are unable to absorb constructive criticism. When programming teams buy into TDD, they immediately see positive results. They eliminate the fear involved in their jobs, and are better equipped to tackle the difficult challenges that face them. TDD eliminates tentative traits, it teaches programmers to communicate, and it encourages team members to seek out criticism However, even the author admits that grumpiness must be worked out individually! In short, the premise behind TDD is that code should be continually tested and refactored. Kent Beck teaches programmers by example, so they can painlessly and dramatically increase the quality of their work.', '32.95', 'http://ecx.images-amazon.com/images/I/51H4NaRMF4L._BO2,204,203,200_PIsitb-sticker-arrow-click,TopRight,35,-76_SX385_SY500_CR,0,0,385,500_SH20_OU03_.jpg');

ALTER TABLE `shop`.`giftcard`
ADD COLUMN `amount` DOUBLE NULL AFTER `code`;
