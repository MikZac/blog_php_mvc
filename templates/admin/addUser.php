
<h1>Dodaj użytkownika</h1>
<div><a href="/admin">Powrót do panelu administratora</a></div>
<div>
    <form action="/add-user" method="post">
        <div>
        <input type="text" placeholder="Imię" name="name" value="">
        </div>
        <div>
        <input type="text" placeholder="Nazwisko" name="surname">
        </div>
        <div>
        <input type="email" placeholder="E-mail" name="email">
        </div>
        <div>
        <input type="password" placeholder="Hasło" name="password">
        </div>
        <div>
        <select name="type">
            <option value="user">Użytkownik</option>
            <option value="admin">Administrator</option>
        </select>
        </div>
        <div>
            <input type="submit" value="Dodaj użytkownika">
        </div>

    </form>
</div>
<?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if($error="validation")
        {
            echo "<p style='color: red;'>Uzupełnij poprawnie pola</p>";
        }
        else if($error="form")
        {
            echo "<p style='color: red;'>Wystąpił błąd podczas przesyłania formularza</p>";
        } 
        
    }
    else if (isset($_GET['successful']))
    {
        echo "<p style='color: green;'>Formularz wysłany poprawnie</p>";
    }
       
    ?>