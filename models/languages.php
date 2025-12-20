<?php

class Language extends Template
{

    //Variables específicas de Language

    //Geters específicos de Language

    //Seters con validacion

    //Seter general con validacion

    
    //Ampliar con variables específicas de Language
    public function __construct(int $id, string $name, bool $insertInBBDD = true)
    {
        parent::__construct("languages", $id, $name);

        //Asignar variables

        if($insertInBBDD)
            $this->insert("(id, name) VALUES ({$id}, '{$name}')");
    }

    //Ampliar con variables y métodos específicos de Language
    public function update(string $name): bool
    {
        $this->name = $name;
        return $this->update("SET name = '{$name}'");
    }

    //Ampliar constructor con variables y métodos específicos de Language
    public static function get(int $id): Language | null
    {
        $data = Template::get("languages", $id);
        if ($data === null) {
            return null;
        }
        return new Language($data['id'], $data['name'], false);
    }
    
    public static function getAll(): array
    {
        return Template::getAll("languages");
    }

    public static function delete(int $id): bool
    {
        return Template::delete("languages", $id);
    }
}
