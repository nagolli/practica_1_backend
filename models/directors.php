<?php

class Director extends Template
{

    //Variables específicas de Director

    //Geters específicos de Director

    //Seters con validacion

    //Seter general con validacion
    
    //Ampliar con variables específicas de Director
    public function __construct(int $id, string $name, bool $insertInBBDD = true)
    {
        parent::__construct("directors", $id, $name);

        //Asignar variables

        if($insertInBBDD)
            $this->insert("(id, name) VALUES ({$id}, '{$name}')");
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
        return new Director($data['id'], $data['name'], false);
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
