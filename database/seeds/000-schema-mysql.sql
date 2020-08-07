DROP TABLE IF EXISTS `adz_category_tpl`;
DROP TABLE IF EXISTS `adz_fieldset_tpl`;
DROP TABLE IF EXISTS `adz_category`;
DROP TABLE IF EXISTS `adz_fieldset`;
DROP TABLE IF EXISTS `adz_opt`;
DROP TABLE IF EXISTS `adz_field`;
DROP TABLE IF EXISTS `adz_user_token`;
DROP TABLE IF EXISTS `adz_user`;


CREATE TABLE `adz_user`
(
    `id`         BIGINT(20)   NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `email`      VARCHAR(100) NOT NULL,
    `password`   VARCHAR(250) NOT NULL,
    `created_at` DATETIME     NOT NULL,
    `role`       VARCHAR(250) DEFAULT NULL,
    `name`       VARCHAR(250) DEFAULT NULL,

    CONSTRAINT `UNIQ_USER_EMAIL` UNIQUE KEY (`email`)
);

CREATE TABLE `adz_user_token`
(
    `id`         BIGINT(20)  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id`    BIGINT(20) DEFAULT NULL,
    `token`      VARCHAR(40) NOT NULL,
    `created_at` DATETIME    NOT NULL,
    `expires_at` DATETIME    NOT NULL,
    `ip`         VARCHAR(15) NOT NULL,

    CONSTRAINT `UNIQ_USER_TOKEN` UNIQUE KEY (`token`),
    CONSTRAINT `FK_TOKEN_ON_USER`
        FOREIGN KEY (`user_id`) REFERENCES `adz_user` (`id`)
            ON UPDATE SET NULL ON DELETE SET NULL,

    INDEX `FK_OPT_ON_FIELD` (`user_id`)
);

CREATE TABLE `adz_field`
(
    `id`        BIGINT(20)  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name`      VARCHAR(40) NOT NULL,
    `type`      VARCHAR(1)  NOT NULL,
    `mandatory` BIT(1)  DEFAULT NULL,
    `size`      INT(11) DEFAULT NULL
);

CREATE TABLE `adz_opt`
(
    `id`       BIGINT(20)  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name`     VARCHAR(40) NOT NULL,
    `field_id` BIGINT(20) DEFAULT NULL,

    CONSTRAINT `FK_OPT_ON_FIELD`
        FOREIGN KEY (`field_id`) REFERENCES `adz_field` (`id`)
            ON UPDATE RESTRICT ON DELETE RESTRICT,

    INDEX `FK_OPT_ON_FIELD` (`field_id`)
);

CREATE TABLE `adz_fieldset`
(
    `id`      BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `heading` VARCHAR(40) DEFAULT NULL
);

CREATE TABLE `adz_category`
(
    `id`          BIGINT(20)   NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name`        VARCHAR(250) NOT NULL,
    `slug`        VARCHAR(250) DEFAULT NULL,
    `description` VARCHAR(250) DEFAULT NULL,
    `keywords` VARCHAR(250) DEFAULT NULL,
    `parent_id`   BIGINT(20)   DEFAULT NULL,

    CONSTRAINT `FK_CATEGORY_ON_PARENT`
        FOREIGN KEY (`parent_id`) REFERENCES `adz_category` (`id`)
            ON UPDATE SET NULL ON DELETE SET NULL,

    INDEX `FK_CATEGORY_ON_PARENT` (`parent_id`)
);

CREATE TABLE `adz_fieldset_tpl`
(
    `id`          BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `weight`      DECIMAL(5, 2) DEFAULT NULL,
    `field_id`    BIGINT(20)    DEFAULT NULL,
    `fieldset_id` BIGINT(20)    DEFAULT NULL,

    CONSTRAINT `FK_FIELDSET_TPL_ON_FIELD`
        FOREIGN KEY (`field_id`) REFERENCES `adz_field` (`id`)
            ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT `FK_FIELDSET_TPL_ON_FIELDSET`
        FOREIGN KEY (`fieldset_id`) REFERENCES `adz_fieldset` (`id`)
            ON UPDATE RESTRICT ON DELETE RESTRICT,

    INDEX `FK_FIELDSET_TPL_ON_FIELD` (`field_id`),
    INDEX `FK_FIELDSET_TPL_ON_FIELDSET` (`fieldset_id`)
);

CREATE TABLE `adz_category_tpl`
(
    `id`          BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `weight`      DECIMAL(5, 2) DEFAULT NULL,
    `category_id` BIGINT(20)    DEFAULT NULL,
    `field_id`    BIGINT(20)    DEFAULT NULL,
    `fieldset_id` BIGINT(20)    DEFAULT NULL,

    CONSTRAINT `FK_CATEGORY_TPL_ON_CATEGORY`
        FOREIGN KEY (`category_id`) REFERENCES `adz_category` (`id`)
            ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT `FK_CATEGORY_TPL_ON_FIELD`
        FOREIGN KEY (`field_id`) REFERENCES `adz_field` (`id`)
            ON UPDATE RESTRICT ON DELETE RESTRICT,
    CONSTRAINT `FK_CATEGORY_TPL_ON_FIELDSET`
        FOREIGN KEY (`fieldset_id`) REFERENCES `adz_fieldset` (`id`)
            ON UPDATE RESTRICT ON DELETE RESTRICT,

    INDEX `FK_CATEGORY_TPL_ON_CATEGORY` (`category_id`),
    INDEX `FK_CATEGORY_TPL_ON_FIELD` (`field_id`),
    INDEX `FK_CATEGORY_TPL_ON_FIELDSET` (`fieldset_id`)
);
