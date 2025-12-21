<?php
// templateForm.php
// Espera: $title, $create, $data, $urlCancel, $urlSubmit
//$data es un array de $title, $id, $type, $currValue, $values con values siendo vacio o un array de duplas id-texto
//$type puede ser 'text', 'date', 'select'
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<form action="<?= $urlSubmit ?>" method="POST">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <?php foreach ($data as $value): ?>
                    <th><?= $value["title"] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($data as $value): ?>
                    <td>
                        <?php if ($value["type"] == "text"): ?>
                            <input type="text" id="<?= $value["id"] ?>" name="<?= $value["id"] ?>" value="<?= $create?null:$value["currValue"] ?>" class="form-control">
                        <?php elseif ($value["type"] == "date"): ?>
                            <input type="date" id="<?= $value["id"] ?>" name="<?= $value["id"] ?>" value="<?= $create?null:$value["currValue"] ?>" class="form-control">
                        <?php elseif ($value["type"] == "select"): ?>
                            <select id="<?= $value["id"] ?>" name="<?= $value["id"] ?>" class="form-control">
                                <option value="">Seleccionar</option>
                                <?php foreach ($value["values"] as $option): ?>
                                    <option value="<?= $option['id'] ?>" <?= ($option['id'] == $value["currValue"]) ? 'selected' : '' ?>><?= $option['text'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-3">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= $urlCancel ?>" class="btn btn-danger" href="<?= $urlCancel ?>">Cancelar</a>
    </div>
</form>
</div>
</body>
</html>