<?php
require_once("../../models/template.php");

class Series extends Template {    
    private string $title;
    //private Platform $platform;
    //private Director $director;
    private int $idPlatform;
    private int $idDirector;
    
    public function getTitle(): string {
        return $this->title;
    }

    public function getIdPlatform(): int {
        return $this->idPlatform;
    }

    public function getIdDirector(): int {
        return $this->idDirector;
    }
    
   public function setTitle(string $title, bool $updateInDB = true): string {
        if (trim($title) === '') {
            return "El titulo no puede estar vacío.";
        }
        $maxLength = 64; 
        if(strlen($title) > $maxLength) {
            return "El titulo no puede tener más de ".$maxLength." caracteres.";
        }
        $this->title = $title;
        if(!$updateInDB) return "OK";
        return $this->updateDirector() ? "OK" : "Error al actualizar el titulo.";
    }    
    
    public function setIdPlatform(int $idPlatform, bool $updateInDB = true): string {  
        if ($idPlatform === '') {
            return "Debe elegir una plataforma.";
        }

        $this->idPlatform = $idPlatform;
        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar el titulo.";
    }  

    public function setIdDirector(int $idDirector, bool $updateInDB = true): string {  
        if ($idDirector === '') {
            return "Debe elegir un director.";
        }

        $this->idDirector = $idDirector;
        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar el titulo.";
    }      

    public function set(string $title, int $idPlatform, int $idDirector): string
    {
        $originalTitle = $this->title;
        $originalIdPlatform = $this->idPlatform ?? 0;
        $originalIdDirector = $this->idDirector ?? 0;        

        $titleResult = $this->setTitle($title, false);
        $idPlatformResult = $this->setIdPlatform($idPlatform, false);
        $idDirectorResult = $this->setIdDirector($idDirector, false);        

        if($titleResult !== "OK" || $idPlatformResult !== "OK" || $idDirectorResult !== "OK") {
            $this->title = $originalTitle;
            $this->idPlatform = $originalIdPlatform;
            $this->idDirector = $originalIdDirector;            
            return $titleResult !== "OK" ? $titleResult : ($idPlatformResult !== "OK" ? $idPlatformResult : ($idDirectorResult !== "OK" ? $idDirectorResult: "OK"));            
        }
        if ($this->id == 0) {
            try {
                $this->insertSeries();
                return "OK";
            } catch (Exception $e) {                                
                return $e->getMessage();
            }            
        }
        return $this->updateSeries() ? "OK" : "Error al actualizar Serie.";
    }

    public function __construct(int $id, string $title, int $idPlatform, int $idDirector)
    {        
        parent::__construct("series", $id, $title);
        $this->title = $title;
        $this->idPlatform = $idPlatform;
        $this->idDirector = $idDirector;
    }

    public function updateSeries(): bool {
         return parent::update("SET title = '{$this->title}', idPlatform = '{$this->idPlatform}', idDirector = '{$this->idDirector}'");
    }

    private function insertSeries(): bool {
        $ret = false;
        try {
            $ret = parent::insert("(title, idPlatform, idDirector) VALUES ('{$this->title}','{$this->idPlatform}','{$this->idDirector}')");
        } catch (Exception $e) {
            // Relanzar la misma Excepcion
            throw $e;
        }
        return true;
    }    
    
    public static function getSeries(int $id): Series | null
    {
        $data = Template::get("series", $id);
        if ($data === null) {
            return null;
        }
        $item=new Series($data['id'], $data['title'], $data['idPlatform'], $data['idDirector']);
        return $item;
    }
    
    public static function getAllSeries(): array
    {
        return Template::getAll("series", "title, idPlatform, idDirector");
    }

    public static function deleteSeries(int $id): bool
    {
        return Template::delete("series", $id);
    }
}
