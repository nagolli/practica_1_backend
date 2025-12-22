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
        if (trim($iso_code) === '') {
            return "El código ISO no puede estar vacío.";
        }
        $maxLength = 2; 
        if(strlen($iso_code) > $maxLength) {
            return "El código ISO no puede tener más de ".$maxLength." caracteres.";
        }
        foreach (self::getAllLanguage() as $language) {
            $existingIso = $language['iso_code'] ?? '';
            $existingId = $language['id'] ?? 0;
            if ($existingIso == $iso_code && $existingId !== $this->id) {
                return "Ya existe un idioma con ese código ISO.";
            }
        }
        $this->iso_code = $iso_code;
        if(!$updateInDB) return "OK";
        return $this->updateLanguage() ? "OK" : "Error al actualizar el código ISO.";
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
            return $nameResult !== "OK" ? $nameResult : ($isoCodeResult !== "OK" ? $isoCodeResult : "OK"); ;
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
        return Template::getAll("languages", "name, iso_code");
    }

    public static function deleteLanguage(int $id): bool
    {
        return Template::delete("languages", $id);
    }
}
