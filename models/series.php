<?php

class Serie extends Template
{

    //Variables específicas de Serie

    //Geters específicos de Serie

    //Seters con validacion

    //Seter general con validacion

    
    //Ampliar con variables específicas de Serie
    public function __construct(int $id, string $name, bool $insertInBBDD = true)
    {
        parent::__construct("series", $id, $name);

        //Asignar variables

        if($insertInBBDD)
            $this->insert("(id, name) VALUES ({$id}, '{$name}')");
    }

    //Ampliar con variables y métodos específicos de Serie
    public function update(string $name): bool
    {
        $this->name = $name;
        return $this->update("SET name = '{$name}'");
    }

    //Ampliar constructor con variables y métodos específicos de Serie
    public static function get(int $id): Serie | null
    {
        $data = Template::get("series", $id);
        if ($data === null) {
            return null;
        }
        return new Serie($data['id'], $data['name'], false);
    }
    
    public static function getAll(): array
    {
        return Template::getAll("series");
    }

    public static function delete(int $id): bool
    {
        return Template::delete("series", $id);
    }
}
