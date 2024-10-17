<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['nombre']; ?></title>
</head>
<body>
    <h1><?php echo $data['nombre']; ?></h1>
    <form id="formulario-publico" method="POST" action="formulario_publico/enviarFormulario">
        <?php foreach ($data['formulario'] as $campo): ?>
            <div class="form-group">
                <label for="<?php echo $campo['name']; ?>"><?php echo $campo['label']; ?></label>
                <input type="<?php echo $campo['type']; ?>" name="campos[<?php echo $campo['name']; ?>]" id="<?php echo $campo['name']; ?>" required>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="idFormulario" value="<?php echo $idFormulario; ?>">
        <button type="submit">Enviar</button>
    </form>

    <script>
        document.getElementById('formulario-publico').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch('formulario_publico/enviarFormulario', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  alert(data.mensaje);
              });
        });
    </script>
</body>
</html>
