
<h1>Edytuj użytkownika</h1>
<div><a href="/admin">Powrót do panelu administratora</a></div>
<div>
    
    <form action="/users?edit=<?php echo $data['user'][0]['id']; ?>" method="post">
        <div>
        <input type="text" placeholder="Imię" name="name" value="<?php echo $data['user'][0]['name']; ?>">
        </div>
        <div>
        <input type="text" placeholder="Nazwisko" name="surname" value="<?php echo $data['user'][0]['surname']; ?>">
        </div>
        <div>
        <input type="email" placeholder="E-mail" name="email" value="<?php echo $data['user'][0]['email']; ?>">
        </div>
        <div>
        <input type="password" placeholder="Hasło" name="password" value="<?php echo $data['user'][0]['password']; ?>">
        </div>
        <div>
        <select name="type">
            <option value="user"<?php echo ($data['user'][0]['type'] == 'user') ? ' selected' : ''; ?>>Użytkownik</option>
            <option value="admin"<?php echo ($data['user'][0]['type'] == 'admin') ? ' selected' : ''; ?>>Administrator</option>
        </select>
        </div>
        <div>
            <input type="submit" value="Edytuj użytkownika">
        </div>

    </form>
</div>