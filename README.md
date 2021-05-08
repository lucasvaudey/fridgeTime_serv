# fridgeTime_serv

<h1>Setup</h1>
<h2>DB</h2>
```
CREATE TABLE `fridgetime`.`user` ( `email` VARCHAR NOT NULL , `username` VARCHAR NOT NULL , `password`
VARCHAR NOT NULL , `recipes` JSON NULL , `fridge` JSON NULL , `subscribecategories` JSON NULL , `id` INT
NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;
```sql
