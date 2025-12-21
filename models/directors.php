<?php
require_once("../../models/template.php");

class Director extends Template
{

    //Variables específicas de Director

    //Geters específicos de Director

    //Seters con validacion

    //Seter general con validacion
    
    //Ampliar con variables específicas de Director
    public function __construct(int $id, string $name)
    {
        parent::__construct("directors", $id, $name);
    }

    //Ampliar con variables y métodos específicos de Director
    public function update(): bool
    {
        return $this->update("SET name = '{$this->name}'");
    }

    //Ampliar constructor con variables y métodos específicos de Director
    public static function getDirector(int $id): Director | null
    {
        $data = Template::get("directors", $id);
        if ($data === null) {
            return null;
        }
        $item=new Director($data['id'], $data['name']);
        return $item;
    }
    
    public static function getAllDirectors(): array
    {
        return Template::getAll("directors");
    }

    public static function deleteDirector(int $id): bool
    {
        return Template::delete("directors", $id);
    }
}
