<?php

class Template
{
    protected int $id;
    protected string $name;
    protected string $table;
    protected static $dbConnection = null;
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    //Setter en clase hija si procede, para actualizar su BBDD

    public function __construct(string $table, int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->table = $table;
    }

    protected static function initConnectionDb(): mysqli
    {
        if (self::$dbConnection === null) {
            $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = 'root';
            $db_db   = 'actividad1';

            $mysqli = @new mysqli($db_host, $db_user, $db_pass, $db_db);

            if($mysqli->connect_error) {
                die("Error: ".$mysqli->connect_error);
            }
            self::$dbConnection = $mysqli;
            return $mysqli;
        } else {
            $mysqli = self::$dbConnection;
        }
        return $mysqli;
    }

    protected function insert(string $sql): bool
    {
        try {
            self::initConnectionDb();
            $sql = "INSERT INTO {$this->table} {$sql}";
            $result = self::$dbConnection->query($sql);
            return $result !== false;
        } catch (mysqli_sql_exception $e) {
            throw new Exception(
                'Error al insertar en la base de datos: ' . $e->getMessage()
            );
        }            
    }

    protected function update(string $sql): bool
    {
        self::initConnectionDb();
        $sql = "UPDATE {$this->table} {$sql} WHERE id = {$this->id}";
        $result = self::$dbConnection->query($sql);
        return $result !== false;
    }

    protected static function get(string $table, int $id): array|null
    {
        self::initConnectionDb();
        $sql = "SELECT * FROM {$table} WHERE id = {$id}";
        $query = self::$dbConnection->query($sql);
        if (!$query) {
            return null;
        }
        $data = $query->fetch_assoc();
        return $data ? $data : null;
    }

    /**
     * Obtiene todos los registros (solo id y name). Se pueden especificar columnas adicionales
     */
    protected static function getAll(string $table, string $columns = "name"): array
    {
        self::initConnectionDb();

        $sql = "SELECT id, {$columns} FROM {$table}";
        $query = self::$dbConnection->query($sql);

        if (!$query) {
            return [];
        }
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Elimina un registro por ID
     */
    protected static function delete(string $table, int $id): bool
    {
        self::initConnectionDb();
        $sql = "DELETE FROM {$table} WHERE id = {$id}";
        $result = self::$dbConnection->query($sql);
        return $result !== false;
    }
}
