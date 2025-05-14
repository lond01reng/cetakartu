<!DOCTYPE html>
<html>
<head>
    <title>Upload & Convert Font (TTF to TCPDF)</title>
</head>
<body>
    <h1>Upload TTF Font for TCPDF</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="<?= base_url('font/upload') ?>">
    <?= csrf_field() ?>
        <label>Select TTF Font File:</label><br>
        <input type="file" name="font_file" accept=".ttf" required><br><br>
        <button type="submit">Upload & Convert</button>
    </form>
</body>
</html>
