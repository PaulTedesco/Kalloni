<?php


namespace App\Utils;


use Exception;
use JetBrains\PhpStorm\Pure;
use PDO;
use PDOException;

abstract class DataBase
{

    protected ?PDO $DB;

    protected function __construct()
    {
        $DATABASE = (getenv("DB_NAME")) ? getenv("DB_NAME") : "ynov_ydays";
        $HOST = (getenv("DB_HOST")) ? getenv("DB_HOST") : "localhost";
        $PORT = (getenv("DB_PORT")) ? getenv("DB_PORT") : "3306";
        $DB_USER = (getenv("DB_USER")) ? getenv("DB_USER") : "root";
        $DB_PASSWORD = (getenv("DB_PASSWORD")) ? getenv("DB_PASSWORD") : "";
        try {
            $this->DB = new PDO("mysql:dbname=" . $DATABASE . ";host=" . $HOST . ";port=" . $PORT, $DB_USER, $DB_PASSWORD);
        } catch (PDOException $e) {
            return 'Connexion échouée : ' . $e->getMessage();
        }
    }

    #[Pure] protected function getVars(object $OBJECT): array
    {
        return get_object_vars($OBJECT);
    }

    /**
     * @param object $OBJECT
     * @return array|null
     * @author pault
     */
    function fetchAll(object $OBJECT): ?array
    {
        $get = $this->DB->prepare("SELECT * FROM `" . $OBJECT::TABLENAME . "`;");
        $get->execute();
        $result = $get->fetchAll(PDO::FETCH_CLASS, get_class($OBJECT));
        return ($result) ? $result : NULL;
    }

    /**
     * @param object $OBJECT
     * @return object|null
     * @author pault
     */
    function fetchOne(object $OBJECT, string $field, string $value): ?object
    {
        $query = "SELECT * FROM `" . $OBJECT::TABLENAME . "` WHERE `" . $field . "`= ?";
        $get = $this->DB->prepare($query);
        $get->execute(array($value));
        $result = $get->fetchAll(PDO::FETCH_CLASS, get_class($OBJECT));
        return (is_array($result) && !empty($result)) ? $result[0] : NULL;
    }


    /**
     * @param object $OBJECT
     * @return Exception|bool|null
     * @author pault
     */

    function create(object $OBJECT): Exception|bool|null
    {
        $array = $this->getVars($OBJECT);
        $sql = "INSERT INTO `" . $OBJECT::TABLENAME . "` ";
        $columnName = "( `id`,";
        $columnValue = "VALUES ( uuid(),";
        foreach ($array as $key => $value):
            if (array_key_last($array) != $key):
                $columnName .= "`$key`,";
                $columnValue .= "?,";
            else:
                $columnName .= "`$key` ) ";
                $columnValue .= "? )";
            endif;
        endforeach;
        $sql .= $columnName . $columnValue;
        $create = $this->DB->prepare($sql);
        return ($create->execute(array_values($array))) ? NULL : new Exception("Une erreur c'est produit à la creation de : " . $OBJECT::TABLENAME);
    }

    /**
     * @param object $OBJECT
     * @return Exception|bool|null
     * @author pault
     */
    function update(object $OBJECT): Exception|bool|null
    {
        $array = $this->getVars($OBJECT);
        $sql = "UPDATE `" . $OBJECT::TABLENAME . "` SET";
        foreach ($array as $key => $value):
            if (array_key_last($array) != $key):
                $sql .= " `$key` = ?,";
            else:
                $sql .= "`$key` = ? WHERE id = ?";
            endif;
        endforeach;
        array_push($array, $OBJECT->getId());
        $update = $this->DB->prepare($sql);
        return ($update->execute(array_values($array))) ? NULL : new Exception("Une erreur c'est produit à la mise à jour de : " . $OBJECT::TABLENAME);
    }


    /**
     * @param object $OBJECT
     * @return Exception|bool|null
     * @author pault
     */
    function delete(object $OBJECT): Exception|bool|null
    {
        $get = $this->DB->prepare("DELETE FROM `" . $OBJECT::TABLENAME . "` WHERE `id`=?;");
        return ($get->execute(array($OBJECT->getId()))) ? NULL : new Exception("Erreur: " . $OBJECT->id . "n'a pas pu être supprimée");
    }


    public function getCount(object $OBJECT)
    {
        $get = $this->DB->prepare("SELECT count(*) FROM " . $OBJECT::TABLENAME);
        $get->execute();
        $count = $get->fetchAll()[0];
        return $count[0];
    }

}
