<?php
require_once("../../models/template.php");

class Series extends Template
{

    //Variables específicas de Serie

    //Geters específicos de Serie

    //Seters con validacion

    //Seter general con validacion

    
    public function __construct(int $id, string $name)
    {
        parent::__construct("series", $id, $name);
    }

    //Ampliar con variables y métodos específicos de Serie
    private function updateSeries(): bool
    {
        return $this->update("SET name = '{$this->name}'");
    }

    private function insertSeries(): bool
    {
        return parent::insert("(name) VALUES ('{$this->name}')");
    }

    //Ampliar constructor con variables y métodos específicos de Serie
    public static function getSeries(int $id): Series | null
    {
        $data = Template::get("series", $id);
        if ($data === null) {
            return null;
        }
        $item=new Series($data['id'], $data['name']);
        return $item;
    }
    
    public static function getAllSeries(): array
    {
        return Template::getAll("series");
    }

    public static function deleteSeries(int $id): bool
    {
        return Template::delete("series", $id);
    }
}
