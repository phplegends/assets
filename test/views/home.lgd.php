<!DOCTYPE html>
<html>
<head>
    <title></title>
    
    [%= Assets::concatStyle(['css/reset.css', 'css/default.css']) %]

    [%= Assets::concatScript(['js/jquery.js', 'chat:index.js']) %]

</head>
<body>
    <section class="container">
        <h1>Autor [%= $nome ?? 'Legendary and Assets' %]</h1>

        <div class="chat-box"></div>
    </section>
</body>
</html>