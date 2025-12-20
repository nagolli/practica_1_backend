<?php

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
        $this->name = $name;
        if(!$updateInDB) return "OK";
        return update() ? "OK" : "Error al actualizar el nombre.";
    }
    public function setSurnames(string $surnames): string
    {
        if (trim($surnames) === '') {
            return "Los apellidos no pueden estar vacíos.";
        }
        $this->surnames = $surnames;
        if(!$updateInDB) return "OK";
        return update() ? "OK" : "Error al actualizar los apellidos.";
    }
    public function setBirthDate(string $birthDate): string
    {
        $d = DateTime::createFromFormat('d/m/Y', $birthDate);
        if (!$d || $d->format('d/m/Y') !== $birthDate) {
            return "Fecha inválida. Debe tener formato dd/mm/yyyy.";
        }
        $this->birthDate = $birthDate;
        if(!$updateInDB) return "OK";
        return update() ? "OK" : "Error al actualizar la fecha de nacimiento.";
    }
    public function setNationality(string $nationality): string
    {
        if (trim($nationality) === '') {
            return "La nacionalidad no puede estar vacía.";
        }
        $this->nationality = $nationality;
        if(!$updateInDB) return "OK";
        return update() ? "OK" : "Error al actualizar la nacionalidad.";
    }
    public function set(string $name, string $surnames, string $birthDate, string $nationality): string
    {
        $originalName = $this->name;
        $originalSurnames = $this->surnames;
        $originalBirthDate = $this->birthDate;
        $originalNationality = $this->nationality;

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
        return update() ? "OK" : "Error al actualizar el actor.";
    }
    
    public function __construct(int $id, string $name, string $surnames, string $birthDate, string $nationality, bool $insertInBBDD = true)
    {
        parent::__construct("actors", $id, $name);

        //Asignar variables
        $this->surnames = $surnames;
        $this->birthDate = $birthDate;
        $this->nationality = $nationality;
        $date = DateTime::createFromFormat('Y-m-d', $birthDate);
        if($insertInBBDD)
            $this->insert("(id, name, surnames, birthDate, nationality) VALUES ({$id}, '{$name}', '{$surnames}', '{$date}', '{$nationality}')");
    }

    public function update(string $name = $this->name, string $surnames = $this->surnames, string $birthDate = $this->birthDate, string $nationality = $this->nationality): bool
    {
        $this->name = $name;
        $this->surnames = $surnames;
        $this->birthDate = $birthDate;
        $this->nationality = $nationality;
        $date = DateTime::createFromFormat('Y-m-d', $birthDate);
        return parent::update("SET name = '{$name}', surnames = '{$surnames}', birthDate = '{$date}', nationality = '{$nationality}'");
    }

    //Ampliar constructor con variables y métodos específicos de Actor
    public static function get(int $id): Actor | null
    {
        $data = Template::get("actors", $id);
        if ($data === null) {
            return null;
        }
        return new Actor($data['id'], $data['name'], $data['surnames'], Template::dateForClient($data['birthDate']), $data['nationality'], false);
    }

    public static function getAll(): array
    {
        return Template::getAll("actors");
    }

    public static function delete(int $id): bool
    {
        return Template::delete("actors", $id);
    }
}
