<?php
require_once("../../models/template.php");

class Language extends Template
{

    private string $iso_code;
    
    public function getIsoCode(): string
    {
        return $this->iso_code;
    }

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
        return $this->updateLanguage() ? "OK" : "Error al actualizar el nombre.";
    }

    public function setIsoCode(string $iso_code, bool $updateInDB = true): string
    {
        $iso_code = trim($iso_code);

        if ($iso_code === '') {
            return "El código ISO no puede estar vacío.";
        }

        if (strlen($iso_code) > 2) {
            return "El código ISO no puede tener más de 2 caracteres.";
        }

        self::initConnectionDb();
        $iso = self::$dbConnection->real_escape_string($iso_code);

        $sql = "SELECT id FROM languages WHERE iso_code = '$iso' AND id != {$this->id} LIMIT 1";
        if (self::$dbConnection->query($sql)->num_rows > 0) {
            return "Ya existe un idioma con ese código ISO.";
        }

        $this->iso_code = $iso_code;

        return !$updateInDB ? "OK" : ($this->updateLanguage() ? "OK" : "Error al actualizar el código ISO.");
    }

    public function set(string $name, string $iso_code): string
    {
        $originalName = $this->name;
        $originalIsoCode = $this->iso_code ?? '';

        $nameResult = $this->setName($name, false);
        $isoCodeResult = $this->setIsoCode($iso_code, false);

        if($nameResult !== "OK" || $isoCodeResult !== "OK") {
            $this->name = $originalName;
            $this->iso_code = $originalIsoCode;
            return $nameResult !== "OK" ? $nameResult : ($isoCodeResult !== "OK" ? $isoCodeResult : "OK"); 
        }
        if ($this->id == 0) {
            return $this->insertLanguage() ? "OK" : "Error al crear el idioma.";
        }
        return $this->updateLanguage() ? "OK" : "Error al actualizar el idioma.";
    }

    
    public function __construct(int $id, string $name)
    {
        parent::__construct("languages", $id, $name);
    }

    //Ampliar con variables y métodos específicos de Language
    public function updateLanguage(): bool
    {
        return parent::update("SET name = '{$this->name}', iso_code = '{$this->iso_code}'");
    }

    public function insertLanguage(): bool
    {
        return parent::insert("(name, iso_code) VALUES ('{$this->name}', '{$this->iso_code}')");
    }

    //Ampliar constructor con variables y métodos específicos de Language
    public static function getLanguage(int $id): Language | null
    {
        $data = Template::get("languages", $id);
        if ($data === null) {
            return null;
        }
        $item=new Language($data['id'], $data['name']);
        $item->setIsoCode($data['iso_code'], false);
        return $item;
    }
    
    public static function getAllLanguage(): array
    {
        // Necesitamos incluir también el id para validar unicidad del ISO correctamente
        return Template::getAll("languages", "id, name, iso_code");
    }

    private static function canDeleteLanguage(int $id): bool
    {
        self::initConnectionDb();
        $sql1 = "
            SELECT count(*) AS total
            FROM dub
            WHERE idLanguage = {$id}
        ";
        $sql2 = "
            SELECT count(*) AS total
            FROM subtitle
            WHERE idLanguage = {$id}
        ";
        $query1 = self::$dbConnection->query($sql1);
        if (!$query1) {
            return false;
        }
        $row1 = $query1->fetch_assoc();
        $query2 = self::$dbConnection->query($sql2);
        if (!$query2) {
            return false;
        }
        $row2 = $query2->fetch_assoc();
        return ((int)$row1['total'] === 0) && ((int)$row2['total'] === 0);
    }

    public static function deleteLanguage(int $id): string
    {
        if(!Language::canDeleteLanguage($id)) {
            return "No se puede eliminar el idioma porque está asociado a una o más series.";
        }
        return Template::delete("languages", $id);
    }
}
