<?php
require_once("../../models/template.php");

class Platform extends Template
{

    public function setName(string $name, bool $updateInDB = true): string
    {
        if (trim($name) === '') {
            return "El nombre no puede estar vacío.";
        }
        $maxLength = 64; 
        if(strlen($name) > $maxLength) {
            return "El nombre no puede tener más de ".$maxLength." caracteres.";
        }
        $this->name = $name;
        if(!$updateInDB) return "OK";
        return updatePlatform() ? "OK" : "Error al actualizar el nombre.";
    }
    
    public function set(string $name): string
    {
        $originalName = $this->name;
        
        $nameResult = $this->setName($name, false);

        if($nameResult !== "OK") {
            $this->name = $originalName;
            return $nameResult;
        }
        if ($this->id == 0) {
            return $this->insertPlatform() ? "OK" : "Error al crear la plataforma.";
        }
        return $this->updatePlatform() ? "OK" : "Error al actualizar la plataforma.";
    }

    public function __construct(int $id, string $name)
    {
        parent::__construct("platforms", $id, $name);
    }

    private function updatePlatform(): bool
    {
        return $this->update("SET name = '{$this->name}'");
    }

    private function insertPlatform(): bool
    {
        return parent::insert("(name) VALUES ('{$this->name}')");
    }

    //Ampliar constructor con variables y métodos específicos de Platform
    public static function getPlatform(int $id): Platform | null
    {
        $data = Template::get("platforms", $id);
        if ($data === null) {
            return null;
        }
        $item=new Platform($data['id'], $data['name']);
        return $item;
    }
    
    public static function getAllPlatforms(): array
    {
        return Template::getAll("platforms");
    }

    private static function canDeletePlatform(int $id): bool
    {
        self::initConnectionDb();
        $sql = "
            SELECT count(*) AS total
            FROM Series
            WHERE idPlatform = {$id}
        ";
        $query = self::$dbConnection->query($sql);
        if (!$query) {
            return false; // o lanza una excepción si prefieres
        }
        $row = $query->fetch_assoc();
        return ((int)$row['total'] === 0);
    }

    public static function deletePlatform(int $id): string
    {
        if(!Platform::canDeletePlatform($id)) {
            return "No se puede eliminar la plataforma porque está asociada a una o más series.";
        }
        return Template::delete("platforms", $id);
    }
}
