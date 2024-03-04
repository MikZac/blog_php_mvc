<h1>Użytkownicy</h1>
<a href="/admin">Powrót do Panelu głównego</a>
<div>
    <table>
        <tr>
            <td>
                ID
            </td>
            <td>
                Imię
            </td>
            <td>
                Nazwisko
            </td>
            <td>
                Email
            </td>
            <td>
                Hasło
            </td>
            <td>
                Typ
            </td>
        </tr>
        <?php foreach($data['users'] as $user): ?>
        <tr>
            <td><?php echo $user["id"]; ?></td>
            <td><?php echo $user["name"]; ?></td>
            <td><?php echo $user["surname"]; ?></td>
            <td><?php echo $user["email"]; ?></td>
            <td><?php echo $user["password"]; ?></td>
            <td><?php echo $user["type"]; ?></td>
            <td><a href="/users?edit=<?php echo $user["id"]?>">Edytuj</a></td>
            <td><a href="/users?remove=<?php echo $user["id"]?>">Usuń</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>