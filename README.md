doctrine-adoption
=================

A small set of classes to make doctrines inheritance mapping more useful.
If you want to use this in Symfony you should take the `benkle/doctrine-adoption-bundle` instead.

Installation
------------

`composer require benkle/doctrine-adoption`

Usage
-----

```php
<?php
$collector = new Benkle\DoctrineAdoption\Collector();

$collector->addAdoptee(ParentEntity::class, ChildEntity::class, 'child');

$eventManager = new EventManager();
$eventManager->addEventListener([Events::loadClassMetadata], new Benkle\DoctrineAdoption\MetadataListener($collector));

$entityManager = EntityManager::create($dbOpts, $config, $eventManager);
```

Please note:
 * The listener is never added automatically, so you'll have to create your own version of the `doctrine` executable for
   the table creation to work properly.
