<?php
require_once("../../models/template.php");

class Language extends Template
{

    //Variables específicas de Language

    //Geters específicos de Language

    //Seters con validacion

    //Seter general con validacion

    
    public function __construct(int $id, string $name)
    {
        parent::__construct("languages", $id, $name);
    }

    //Ampliar con variables y métodos específicos de Language
    public function updateLanguage(): bool
    {
        return $this->update("SET name = '{$this->name}'");
    }

    public function insertLanguage(string $name): bool
    {
        $this->name = $name;
        return $this-insert("(name) VALUES ('{$this->name}')");
    }

    //Ampliar constructor con variables y métodos específicos de Language
    public static function getLanguage(int $id): Language | null
    {
        $data = Template::get("languages", $id);
        if ($data === null) {
            return null;
        }
        $item=new Language($data['id'], $data['name']);
        return $item;
    }
    
    public static function getAllLanguage(): array
    {
        return Template::getAll("languages");
    }

    public static function deleteLanguage(int $id): bool
    {
        return Template::delete("languages", $id);
    }
}
