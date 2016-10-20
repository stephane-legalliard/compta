<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="microcms.css" rel="stylesheet" />
    <title>compta - Home</title>
</head>
<body>
    <header>
        <h1>Compta</h1>
    </header>
    <?php foreach ($users as $user): ?>
    <article>
        <h2><?php echo $user->getUser() ?></h2>
        <p><?php echo $article->getContent() ?></p>
    </article>
    <?php endforeach; ?>
    <!--<footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>-->
</body>
</html>