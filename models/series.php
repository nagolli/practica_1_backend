<?php
require_once("../../models/template.php");

class Series extends Template {
    private string $title;
    private int $idPlatform;
    private int $idDirector;
    private array $idActors;
    private int $idActorProtagonist;
    private array $idAudioLanguages;
    private array $idSubtitleLanguages;
    private int $idAudioLanguageOriginal;
    private int $idSubtitleLanguageOriginal;
    
    public function getTitle(): string {
        return $this->title;
    }

    public function getIdPlatform(): int {
        return $this->idPlatform;
    }

    public function getIdDirector(): int {
        return $this->idDirector;
    }

    public function getIdActors(): array {
        return $this->idActors;
    }

    public function getIdActorProtagonist(): int {
        return $this->idActorProtagonist;
    }

    public function getIdAudioLanguages(): array {
        return $this->idAudioLanguages;
    }

    public function getIdSubtitleLanguages(): array {
        return $this->idSubtitleLanguages;
    }

    public function getIdAudioLanguageOriginal(): int {
        return $this->idAudioLanguageOriginal;
    }

    public function getIdSubtitleLanguageOriginal(): int {
        return $this->idSubtitleLanguageOriginal;
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

    public function setIdActors(array $idActors, bool $updateInDB = true): string {
        //Si alguna entrada de actor no es un id numerico
        if (array_filter($idActors, fn($actor) => !is_numeric($actor))) {
            return "Id de actor inválido.";
        }

        //Si idActorsProtagonists tiene algún actor que también está en idActors se elimina de idActors
        $this->idActors = array_diff($idActors, [$this->idActorProtagonist]);

        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar los actores.";
    }

    public function setIdActorProtagonist(int $idActorProtagonist, bool $updateInDB = true): string {
        if ($idActorProtagonist === '') {
            return "Debe elegir un actor protagonista.";
        }

        //Si idActorsProtagonists tiene algún actor que también está en idActors se elimina de idActors
        $this->idActors = array_diff($this->idActors, [$this->idActorProtagonist]);

        $this->idActorProtagonist = $idActorProtagonist;
        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar el actor protagonista.";
    }

    public function setIdAudioLanguageOriginal(int $idAudioLanguageOriginal, bool $updateInDB = true): string {
        if ($idAudioLanguageOriginal === '') {
            return "Debe elegir un idioma de audio original.";
        }
        //Si idAudioLanguageOriginal está en idAudioLanguages se elimina de idAudioLanguages
        $this->idAudioLanguages = array_diff($this->idAudioLanguages, [$idAudioLanguageOriginal]);

        $this->idAudioLanguageOriginal = $idAudioLanguageOriginal;
        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar el idioma de audio original.";
    }

    public function setIdSubtitleLanguageOriginal(int $idSubtitleLanguageOriginal, bool $updateInDB = true): string {
        if ($idSubtitleLanguageOriginal === '') {
            return "Debe elegir un idioma de subtítulos original.";
        }
        //Si idSubtitleLanguageOriginal está en idSubtitleLanguages se elimina de idSubtitleLanguages
        $this->idSubtitleLanguages = array_diff($this->idSubtitleLanguages, [$idSubtitleLanguageOriginal]);

        $this->idSubtitleLanguageOriginal = $idSubtitleLanguageOriginal;
        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar el idioma de subtítulos original.";
    }

    public function setIdAudioLanguages(array $idAudioLanguages, bool $updateInDB = true): string {
        if (empty($idAudioLanguages)) {
            return "Debe elegir al menos un idioma de audio.";
        }
        //Si alguna entrada de idioma de audio no es un id numerico
        if (array_filter($idAudioLanguages, fn($audioLanguage) => !is_numeric($audioLanguage))) {
            return "Id de idioma de audio inválido.";
        }

        //Si idAudioLanguageOriginal está en idAudioLanguages se elimina de idAudioLanguages
        $this->idAudioLanguages = array_diff($idAudioLanguages, [$this->idAudioLanguageOriginal]);

        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar los idiomas de audio.";
    }

    public function setIdSubtitleLanguages(array $idSubtitleLanguages, bool $updateInDB = true): string {
        if (empty($idSubtitleLanguages)) {
            return "Debe elegir al menos un idioma de subtítulos.";
        }
        //Si alguna entrada de idioma de subtítulos no es un id numérico
        if (array_filter($idSubtitleLanguages, fn($subtitleLanguage) => !is_numeric($subtitleLanguage))) {
            return "Id de idioma de subtítulos inválido.";
        }

        //Si idSubtitleLanguageOriginal está en idSubtitleLanguages se elimina de idSubtitleLanguages
        $idSubtitleLanguages = array_diff($idSubtitleLanguages, [$this->idSubtitleLanguageOriginal]);

        if(!$updateInDB) return "OK";
        return $this->updateSeries() ? "OK" : "Error al actualizar los idiomas de subtítulos.";
    }

    public function set(string $title, int $idPlatform, int $idDirector, array $idActors, int $idActorProtagonist, array $idAudioLanguages, array $idSubtitleLanguages, int $idAudioLanguageOriginal, int $idSubtitleLanguageOriginal): string
    {
        $originalTitle = $this->title;
        $originalIdPlatform = $this->idPlatform ?? 0;
        $originalIdDirector = $this->idDirector ?? 0;
        $originalIdActors = $this->idActors ?? [];
        $originalIdActorsProtagonists = $this->idActorProtagonist ?? [];
        $originalIdAudioLanguages = $this->idAudioLanguages ?? [];
        $originalIdSubtitleLanguages = $this->idSubtitleLanguages ?? [];
        $originalIdAudioLanguageOriginal = $this->idAudioLanguageOriginal ?? 0;
        $originalIdSubtitleLanguageOriginal = $this->idSubtitleLanguageOriginal ?? 0;

        $titleResult = $this->setTitle($title, false);
        $idPlatformResult = $this->setIdPlatform($idPlatform, false);
        $idDirectorResult = $this->setIdDirector($idDirector, false);
        $idActorProtagonistResult = $this->setIdActorProtagonist($idActorProtagonist, false);
        $idActorsResult = $this->setIdActors($idActors, false);
        $idAudioLanguagesResult = $this->setIdAudioLanguages($idAudioLanguages, false);
        $idSubtitleLanguagesResult = $this->setIdSubtitleLanguages($idSubtitleLanguages, false);
        $idAudioLanguageOriginalResult = $this->setIdAudioLanguageOriginal($idAudioLanguageOriginal, false);
        $idSubtitleLanguageOriginalResult = $this->setIdSubtitleLanguageOriginal($idSubtitleLanguageOriginal, false);

        if($titleResult !== "OK" || $idPlatformResult !== "OK" || $idDirectorResult !== "OK" || $idActorsResult !== "OK"|| $idActorProtagonistResult !== "OK" || $idAudioLanguagesResult !== "OK" || $idSubtitleLanguagesResult !== "OK" || $idAudioLanguageOriginalResult !== "OK" || $idSubtitleLanguageOriginalResult !== "OK") {
            $this->title = $originalTitle;
            $this->idPlatform = $originalIdPlatform;
            $this->idDirector = $originalIdDirector;
            $this->idActors = $originalIdActors;
            $this->idActorProtagonist = $originalIdActorsProtagonists;
            $this->idAudioLanguages = $originalIdAudioLanguages;
            $this->idSubtitleLanguages = $originalIdSubtitleLanguages;
            $this->idAudioLanguageOriginal = $originalIdAudioLanguageOriginal;
            $this->idSubtitleLanguageOriginal = $originalIdSubtitleLanguageOriginal;
            return $titleResult !== "OK" ? $titleResult : (
                $idPlatformResult !== "OK" ? $idPlatformResult : (
                $idDirectorResult !== "OK" ? $idDirectorResult: (
                $idActorsResult !== "OK" ? $idActorsResult :(
                $idActorProtagonistResult !== "OK" ? $idActorProtagonistResult : (
                $idAudioLanguagesResult !== "OK" ? $idAudioLanguagesResult : (
                $idSubtitleLanguagesResult !== "OK" ? $idSubtitleLanguagesResult : (
                $idAudioLanguageOriginalResult !== "OK" ? $idAudioLanguageOriginalResult : 
                $idSubtitleLanguageOriginalResult)))))));
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

    public function __construct(int $id, string $title, int $idPlatform, int $idDirector, array $idActors, int $idActorsProtagonists, array $idAudioLanguages, array $idSubtitleLanguages, int $idAudioLanguageOriginal, int $idSubtitleLanguageOriginal)
    {
        parent::__construct("series", $id, $title);
        $this->title = $title;
        $this->idPlatform = $idPlatform;
        $this->idDirector = $idDirector;
        $this->idActors = $idActors;
        $this->idActorProtagonist = $idActorsProtagonists;
        $this->idAudioLanguages = $idAudioLanguages;
        $this->idSubtitleLanguages = $idSubtitleLanguages;
        $this->idAudioLanguageOriginal = $idAudioLanguageOriginal;
        $this->idSubtitleLanguageOriginal = $idSubtitleLanguageOriginal;
    }

    private function insertSeries(): bool {
        $ret = false;
        try {
            $ret = parent::insert("(title, idPlatform, idDirector) VALUES ('{$this->title}','{$this->idPlatform}','{$this->idDirector}')",[
                //Insertar actor protagonista
                "INSERT INTO act(idSeries, idActor, protagonist) VALUES (LAST_INSERT_ID(), {$this->idActorProtagonist}, true)",
                //Insertar actores secundarios
                ...array_map(fn($actorId) => "INSERT INTO act(idSeries, idActor, protagonist) VALUES (LAST_INSERT_ID(), {$actorId}, false)", $this->idActors),
                //Insertar idioma de audio original
                "INSERT INTO dub (idSeries, idLanguage, original) VALUES (LAST_INSERT_ID(), {$this->idAudioLanguageOriginal}, true)",
                //Insertar idioma de subtítulos original
                "INSERT INTO subtitle (idSeries, idLanguage, original) VALUES (LAST_INSERT_ID(), {$this->idSubtitleLanguageOriginal}, true)",
                //Insertar idiomas de audio
                ...array_map(fn($audioLanguageId) => "INSERT INTO dub (idSeries, idLanguage, original) VALUES (LAST_INSERT_ID(), {$audioLanguageId}, false)", $this->idAudioLanguages),
                //Insertar idiomas de subtítulos
                ...array_map(fn($subtitleLanguageId) => "INSERT INTO subtitle (idSeries, idLanguage, original) VALUES (LAST_INSERT_ID(), {$subtitleLanguageId}, false)", $this->idSubtitleLanguages)
            ]);
        } catch (Exception $e) {
            // Relanzar la misma Excepcion
            throw $e;
        }
        return true;
    }
    
    protected static function getWhereSeries(string $table,int $id,string $columnToReturn,string $orderBy): array|null
    {
        self::initConnectionDb();
        $sql = "
            SELECT {$columnToReturn}
            FROM {$table}
            WHERE idSeries = {$id}
            ORDER BY {$orderBy} DESC
        ";
        $query = self::$dbConnection->query($sql);
        if (!$query) {
            return null;
        }
        $result = [];
        while ($row = $query->fetch_assoc()) {
            $result[] = (int)$row[$columnToReturn];
        }
    return $result ?: null;
    }

    public static function getSeries(int $id): Series | null
    {
        $data = Template::get("series", $id);
        if ($data === null) {
            return null;
        }
        $actors = Series::getWhereSeries("act", $data['id'], "idActor", "protagonist");
        $actorProtagonist = $actors ? array_shift($actors) : null;
        $dubbing = Series::getWhereSeries("dub", $data['id'], "idLanguage", "original");
        $dubbingOriginal = $dubbing ? array_shift($dubbing) : null;
        $subtitles = Series::getWhereSeries("subtitle", $data['id'], "idLanguage", "original");
        $subtitlesOriginal = $subtitles ? array_shift($subtitles) : null;
        $item=new Series(
            $data['id'],
            $data['title'],
            $data['idPlatform'],
            $data['idDirector'],
            $actors,
            $actorProtagonist,
            $subtitles,
            $dubbing,
            $subtitlesOriginal,
            $dubbingOriginal);
        return $item;
    }
    
    public static function getAllSeries(): array
    {
        return Template::getAll("series", "title");
    }

    public static function deleteSeries(int $id): string
    {
        return Template::delete("series", $id,
        [
            "DELETE FROM act WHERE idSeries = {$id}",
            "DELETE FROM dub WHERE idSeries = {$id}",
            "DELETE FROM subtitle WHERE idSeries = {$id}"
        ]);
    }

    public function updateSeries(): string
    {
        return parent::update(
            "SET title = '{$this->title}', idPlatform = '{$this->idPlatform}', idDirector = '{$this->idDirector}'",
            [
                // Actores
                "DELETE FROM act WHERE idSeries = {$this->id}",
                // Actor protagonista
                "INSERT INTO act(idSeries, idActor, protagonist) VALUES ({$this->id}, {$this->idActorProtagonist}, true)",
                // Actores secundarios
                ...array_map(
                    fn($actorId) =>
                        "INSERT INTO act(idSeries, idActor, protagonist) VALUES ({$this->id}, {$actorId}, false)",
                    $this->idActors
                ),

                // Idiomas de audio
                "DELETE FROM dub WHERE idSeries = {$this->id}",
                // Idioma de audio original
                "INSERT INTO dub (idSeries, idLanguage, original) VALUES ({$this->id}, {$this->idAudioLanguageOriginal}, true)",
                ...array_map(
                    fn($audioLanguageId) =>
                        "INSERT INTO dub (idSeries, idLanguage, original) VALUES ({$this->id}, {$audioLanguageId}, false)",
                    $this->idAudioLanguages
                ),

                // Idiomas de subtítulos
                "DELETE FROM subtitle WHERE idSeries = {$this->id}",
                // Idioma de subtítulos original
                "INSERT INTO subtitle (idSeries, idLanguage, original) VALUES ({$this->id}, {$this->idSubtitleLanguageOriginal}, true)",
                ...array_map(
                    fn($subtitleLanguageId) =>
                        "INSERT INTO subtitle (idSeries, idLanguage, original) VALUES ({$this->id}, {$subtitleLanguageId}, false)",
                    $this->idSubtitleLanguages
                )
            ]
        );
    }
}
