<?= $this->extend("/user/layout/template") ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<style>
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border: 1px solid #dee2e6;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e9ecef;
    }

    .form-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    h5 {
        margin-bottom: 20px;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="info-section my-4">
                <h4 class="fw-bold mb-3">Normativa de Pesca en Galicia 2024</h4>
                <p class="mb-4">
                    La normativa se actualiza cada año. Puedes consultar toda la información oficial directamente en la página de la Xunta de Galicia:
                </p>
                <a href="https://www.xunta.gal/dog/Publicados/2024/20240220/AnuncioG0691-300124-0001_es.html"
                    class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                    Consultar Normativa
                </a>
            </div>

            <div class="info-section my-4">
                <h5 class="fw-semibold mt-4">Consulta de Aguas Vedadas por Provincia</h5>
           
            </div>

            <div class="form-container">
                <form action="/user/normativa" method="get">
                    <div class="mb-3">
                        <label for="provincia" class="form-label">Selecciona Provincia</label>
                        <select name="provincia" id="provincia" class="form-select">
                            <option value="A CORUÑA" <?= (old('provincia') == 'A CORUÑA' || $provincia == 'A CORUÑA') ? 'selected' : '' ?>>A CORUÑA</option>
                            <option value="LUGO" <?= (old('provincia') == 'LUGO' || $provincia == 'LUGO') ? 'selected' : '' ?>>LUGO</option>
                            <option value="OURENSE" <?= (old('provincia') == 'OURENSE' || $provincia == 'OURENSE') ? 'selected' : '' ?>>OURENSE</option>
                            <option value="PONTEVEDRA" <?= (old('provincia') == 'PONTEVEDRA' || $provincia == 'PONTEVEDRA') ? 'selected' : '' ?>>PONTEVEDRA</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>

            <div class="table-responsive mt-4">
                <?= $tableContent; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>