<h1>Wpisy blogowe</h1>
<a href="/admin">Powrót do Panelu głównego</a>
<div>
    <table>
        <tr>
            <td>
                ID
            </td>
            <td>
                Tytuł
            </td>
            <td>
                Edytuj
            </td>
            <td>
                Usuń
            </td>
        </tr>
        <?php foreach($data['posts'] as $post): ?>
        <tr>
            <td><?php echo $post["id"]; ?></td>
            <td><?php echo $post["title"]; ?></td>
            <td><a href="/posts?edit=<?php echo $post["id"]?>">Edytuj</a></td>
            <td><a href="/posts?remove=<?php echo $post["id"]?>">Usuń</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
