# fridgeTime_serv

## Setup
### DB
```sql
CREATE TABLE `fridgetime`.`user` ( `email` VARCHAR NOT NULL , `username` VARCHAR NOT NULL , `password`
VARCHAR NOT NULL , `recipes` JSON NULL , `fridge` JSON NULL , `subscribecategories` JSON NULL , `id` INT
NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```
