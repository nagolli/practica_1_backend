<?php
// templateForm.php
// Espera: $title, $create, $data, $urlCancel, $urlSubmit, $itemId, $maxWidth
//$data es un array de $title, $id, $type, $currValue, $values con values siendo vacio o un array de duplas id-texto
//$type puede ser 'text', 'date', 'select'
$maxWidth = $maxWidth ?? 8;
$chunks = array_chunk($data, $maxWidth);
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
    <input type="hidden" name="id" value="<?= $itemId ?? 0 ?>">

    <?php foreach ($chunks as $chunk): ?>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <?php foreach ($chunk as $value): ?>
                        <th><?= htmlspecialchars($value["title"]) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($chunk as $value): ?>
                        <td>
                            <?php if ($value["type"] === "text"): ?>
                                <input type="text"
                                       name="<?= $value["id"] ?>"
                                       value="<?= !$create ? htmlspecialchars($value["currValue"] ?? '') : '' ?>"
                                       class="form-control">

                            <?php elseif ($value["type"] === "date"): ?>
                                <input type="date"
                                       name="<?= $value["id"] ?>"
                                       value="<?= !$create ? htmlspecialchars($value["currValue"] ?? '') : '' ?>"
                                       class="form-control">

                            <?php elseif ($value["type"] === "select"): ?>
                                <select name="<?= $value["id"] ?>" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($value["values"] as $option): ?>
                                        <option value="<?= $option['id'] ?>"
                                            <?= (!$create && $option['id'] == $value["currValue"]) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($option['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            <?php elseif ($value["type"] === "multiSelect"): ?>
                                <?php $selectedValues = $create ? [] : (array)$value["currValue"]; ?>
                                <select name="<?= $value["id"] ?>[]" class="form-control" multiple>
                                    <?php foreach ($value["values"] as $option): ?>
                                        <option value="<?= $option['id'] ?>"
                                            <?= in_array($option['id'], $selectedValues) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($option['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>

    <div class="d-flex justify-content-between mt-3">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= $urlCancel ?>" class="btn btn-danger">Cancelar</a>
    </div>
</form>
</div>
</body>
</html>