<?php

class Platform extends Template
{

    //Variables específicas de Platform

    //Geters específicos de Platform

    //Seters con validacion

    //Seter general con validacion

    
    //Ampliar con variables específicas de Platform
    public function __construct(int $id, string $name, bool $insertInBBDD = true)
    {
        parent::__construct("platforms", $id, $name);

        //Asignar variables

        if($insertInBBDD)
            $this->insert("(id, name) VALUES ({$id}, '{$name}')");
    }

    //Ampliar con variables y métodos específicos de Platform
    public function update(string $name): bool
    {
        $this->name = $name;
        return $this->update("SET name = '{$name}'");
    }

    //Ampliar constructor con variables y métodos específicos de Platform
    public static function get(int $id): Platform | null
    {
        $data = Template::get("platforms", $id);
        if ($data === null) {
            return null;
        }
        return new Platform($data['id'], $data['name'], false);
    }
    
    public static function getAll(): array
    {
        return Template::getAll("platforms");
    }

    public static function delete(int $id): bool
    {
        return Template::delete("platforms", $id);
    }
}
