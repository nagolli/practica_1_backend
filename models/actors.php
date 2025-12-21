<?php
require_once("../../models/template.php");

class Actor extends Template
{
    private string $surnames;
    private string $birthDate;
    private string $nationality;

    public function getSurnames(): string
    {
        return $this->surnames;
    }
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }
    public function getNationality(): string
    {
        return $this->nationality;
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
        return updateActor() ? "OK" : "Error al actualizar el nombre.";
    }
    public function setSurnames(string $surnames, bool $updateInDB = true): string
    {
        if (trim($surnames) === '') {
            return "Los apellidos no pueden estar vacíos.";
        }
        $maxLength = 64; 
        if(strlen($surnames) > $maxLength) {
            return "Los apellidos no pueden tener más de ".$maxLength." caracteres.";
        }
        $this->surnames = $surnames;
        if(!$updateInDB) return "OK";
        return updateActor() ? "OK" : "Error al actualizar los apellidos.";
    }
    public function setBirthDate(string $birthDate, bool $updateInDB = true): string
    {
        $d = DateTime::createFromFormat('Y-m-d', $birthDate);
        if (!$d || $d->format('Y-m-d')!=$birthDate) {
            return "Fecha inválida. Debe tener formato dd/mm/yyyy.";
        }
        $this->birthDate = $birthDate;
        if(!$updateInDB) return "OK";
        return updateActor() ? "OK" : "Error al actualizar la fecha de nacimiento.";
    }
    public function setNationality(string $nationality, bool $updateInDB = true): string
    {
        if (trim($nationality) === '') {
            return "La nacionalidad no puede estar vacía.";
        }
        $maxLength = 64;
        if(strlen($nationality) > $maxLength) {
            return "La nacionalidad no puede tener más de ".$maxLength." caracteres.";
        }
        $this->nationality = $nationality;
        if(!$updateInDB) return "OK";
        return updateActor() ? "OK" : "Error al actualizar la nacionalidad.";
    }
    public function set(string $name, string $surnames, string $birthDate, string $nationality): string
    {
        $originalName = $this->name;
        $originalSurnames = $this->surnames ?? '';
        $originalBirthDate = $this->birthDate ?? '';
        $originalNationality = $this->nationality ?? '';

        $nameResult = $this->setName($name, false);
        $surnameResult = $this->setSurnames($surnames, false);
        $birthDateResult = $this->setBirthDate($birthDate, false);
        $nationalityResult = $this->setNationality($nationality, false);

        if($nameResult !== "OK" || $surnameResult !== "OK" || $birthDateResult !== "OK" || $nationalityResult !== "OK") {
            $this->name = $originalName;
            $this->surnames = $originalSurnames;
            $this->birthDate = $originalBirthDate;
            $this->nationality = $originalNationality;
            return $nameResult !== "OK" ? $nameResult : ($surnameResult !== "OK" ? $surnameResult : ($birthDateResult !== "OK" ? $birthDateResult : $nationalityResult));
        }
        if ($this->id == 0) {
            return $this->insertActor() ? "OK" : "Error al crear el actor.";
        }
        return $this->updateActor() ? "OK" : "Error al actualizar el actor.";
    }
    
    public function __construct(int $id, string $name)
    {
        parent::__construct("actors", $id, $name);
    }

    private function updateActor(): bool
    {
        return parent::update("SET name = '{$this->name}', surnames = '{$this->surnames}', birthDate = '{$this->birthDate}', nationality = '{$this->nationality}'");
    }

    private function insertActor(): bool
    {
        return parent::insert("(name, surnames, birthDate, nationality) VALUES ('{$this->name}','{$this->surnames}','{$this->birthDate}','{$this->nationality}' )");
    }

    //Ampliar constructor con variables y métodos específicos de Actor
    public static function getActor(int $id): Actor | null
    {
        $data = Template::get("actors",$id);
        if ($data === null) {
            return null;
        }
        $item=new Actor($data['id'], $data['name']);
        $item->setSurnames($data['surnames'], false);
        $item->setBirthDate($data['birthDate'], false);
        $item->setNationality($data['nationality'], false);
        return $item;
    }

    public static function getAllActors(): array
    {
        return Template::getAll("actors", "name, surnames");
    }

    public static function deleteActor(int $id): bool
    {
        return Template::delete("actors", $id);
    }
}
