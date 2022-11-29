# PHP Filter Array Like SQL

## Layout
 
```txt
AR
|
|-- ::updateAll
    |
    |-- db->createCommand() // Command
    |
    |-- Command->update() // Command
            |
            |-- db->getQueryBuilder() // QueryBuilder
            |
            |-- QueryBuilder->update() // string
            |
            |-- Command->setSql()->bindValues() // Command
    |
    |-- Command->execute() // int

Clz->updateAll()->db->createCommand()Command->update()->

// 
AR
|
|-- ::findAll
    |
    |-- ::findByCondition // ActiveQueryInterface
        |
        |-- ::find()
    |
    |-- ActiveQueryInterface->all()
``` 

## Examples

```php
$qa = new QueryArray([
        ["name" => "Li", "age" => 10],
        ["name" => "Zhang", "age" => 9],
    ]);
$qa->andWhere(["name" => "Zhang"])->all();
```

## References

- https://github.com/Jakiboy/SQL-it/blob/master/src/SQLit.php