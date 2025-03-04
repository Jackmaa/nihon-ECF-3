<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create A Manga</title>
</head>
<body>
    <form action="/create" method="post" enctype="multipart/form-data" id="create-form">
        <input type="text" name="name" placeholder="Title">
        <input type="text" name="author" placeholder="Author" id="author">
        <div id="response"></div>
        <textarea type="text" name="description" placeholder="Description"></textarea>
        <input type="date" name="published_date" id="published_date">
        <input type="file" name="thumbnail" id="thumbnail">
        <button type="submit">Create</button>
    </form>
    <script src="./public/asset/js/ajax.js"></script>
</body>
</html>