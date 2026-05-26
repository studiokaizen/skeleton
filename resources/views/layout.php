<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($this->yield('title', 'App')) ?></title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

<nav>
    <a href="/">Home</a>
</nav>

<main>
    <?= $this->yield('content') ?>
</main>

</body>
</html>
