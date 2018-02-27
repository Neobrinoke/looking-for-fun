<?php

namespace App\Entity;

//use PDO;
//use ReflectionClass;
//use ReflectionProperty;

class Entity
{

}

//abstract class Entity
//{
//    /**
//     * Define id for this entity
//     *
//     * @return mixed
//     */
//    abstract public function getId();
//
//    /**
//     * Function for get PDO
//     */
//    private static function getPDO()
//    {
//        return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';port=' . DB_PORT . '', DB_USERNAME, DB_PASSWORD);
//    }
//
//    /**
//     * Find all by something
//     *
//     * @param array $options
//     * @return array
//     */
//    public static function findBy(array $options = []): array
//    {
//        // find all by something...
//        return [];
//    }
//
//    /**
//     * Find one by something
//     *
//     * @param array $options
//     * @return Entity|null
//     */
//    public static function findOneBy(array $options = [])
//    {
//        $statement = self::getPDO()->query('select * from users where id = 1');
//        $result = $statement->fetch(PDO::FETCH_CLASS);
//        return $result;
//    }
//
//    /**
//     * Create current entity
//     */
//    public function create()
//    {
//        $fields = self::getAllField($this);
//        var_dump($fields);
//    }
//
//    /**
//     * Update current entity
//     */
//    private function update()
//    {
//        //
//    }
//
//    /**
//     * Save(insert or update) current entity
//     */
//    public function save()
//    {
//        if(self::findBy(['id' => $this->getId()])) { // update
//            var_dump('Update');
//        } else { // create
//            var_dump('Create');
//        }
//    }
//
//    /**
//     * Parse php doc for get all db field
//     *
//     * @param Entity $entity
//     * @return array
//     */
//    private static function getAllField(Entity $entity)
//    {
//        $reflectEntity = new \ReflectionObject($entity);
//
//        $fields = [];
//
//        /** @var ReflectionProperty $property */
//        foreach ($reflectEntity->getProperties() as $property) {
//            preg_match('~@column\(name="(.*?)"\)~', $property->getDocComment(), $match);
//            if (!empty($match) && $match[1] != 'id') {
//                $fields[] = $match[1];
//            }
//        }
//
//        return $fields;
//    }
//}