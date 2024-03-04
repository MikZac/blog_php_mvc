<?php

require_once("src/view.php");
require_once("src/Database.php");

class AdminController {

    private $view;
    private $db;

    public function __construct() {
        $this->view = new View("templates/admin/");
        $this->db = new Database(require('config/config.php'));
    }

    public function admin() {
        if ($this->isLoggedIn()) {
            $this->view->render('admin');
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function renderAddUser() {
        if ($this->isLoggedIn()) {
            $this->view->render('addUser');
        } else {
            header("Location: /login");
            exit();
        }
    }

    private function isLoggedIn() {
        return isset($_SESSION['email']);
    }

    public function validateAddUser() {
        
        if (empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['type'])) {
            return "Wszystkie pola są wymagane";
        }
        // Sprawdzenie poprawności adresu email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return "Niepoprawny adres email";
        }
        // Sprawdzenie długości hasła
        if (strlen($_POST['password']) < 6) {
            return "Hasło musi mieć co najmniej 6 znaków";
        }
        $emailExists = $this->db->checkEmailExist($_POST['email']);
        if($emailExists){
            return "Podany adres E-mail istnieje";
        }
        return true;
    }

    public function validateEditUser() {
        
        if (empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['type'])) {
            return "Wszystkie pola są wymagane";
        }
        // Sprawdzenie poprawności adresu email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return "Niepoprawny adres email";
        }
        // Sprawdzenie długości hasła
        if (strlen($_POST['password']) < 6) {
            return "Hasło musi mieć co najmniej 6 znaków";
        }
        return true;
    }

    public function users() {
        if ($this->isLoggedIn()) {
            
            $users = $this->db->showUsers();
            $this->view->render('Users', ['users' => $users]);
            
        } else {
            header("Location: /login");
            exit();
        }

    
    }
    public function removeUser() {

        if(isset($_GET['remove']))
        {
           
            $userID = $_GET['remove'];
            $success = $this->db->removeUserFromDatabase($userID);
            if($success) {
                header('Location: /users');
                exit();
            }
            else{
                echo "Nie udało się usunąć użytkownika";
            }
        }
        else {
            echo "wystąpił błąd";
            exit();
        }
    }

    public function renderEditUser($userID) {
        if(isset($_GET['edit']))
        {
            $userID = $_GET['edit'];
            $user = $this->db->showEditUser($userID);
            
             $this->view->render('editUser',['user' => $user]);
        }
    }

    public function editUser($userID) {
        
        $validationResult = $this->validateEditUser();

        if($validationResult !== true) {
            header("Location: /users?edit=$userID&error=validation");
            exit();
        }
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = $_POST['type'];
            dump($name);
            $this->db->editUserInDatabase($userID, $name, $surname, $email, $password, $type);  
        } else {
            header("Location: /users?edit=$userID&error=validationV2");
            exit();
        }
    
        header("Location: /users");
        exit();
    }

    public function addUser() {
        

        $validationResult = $this->validateAddUser();

        if ($validationResult !== true) {
            header("Location: /add-user?error=validation");
            exit();
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = $_POST['type'];
            
            $this->db->addUserToDatabase($name, $surname, $email, $password, $type);   
        }
        else {
            header("Location: /add-user?error=form");
            exit();
        }
        header("Location: /add-user?successful");
        exit();
    }

    public function renderAddPost () {
        $this->view->render('addPost');
    }

    public function addPost () {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $sciezka = $_POST['sciezka'];
            $content = $_POST['content'];

            $photo_path = ''; 
        if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../../public/photos/'; 
            $photo_name = $_FILES['photo']['name'];
            $photo_path = '/public/photos/'. $photo_name;
            $upload_path = $upload_dir . $photo_name;
            move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path);
            
            $this->db->addPostToDatabase($title, $content, $sciezka, $photo_path);   
        }
    }
    
    header("Location: /admin");
    exit();
    }

    public function posts(){
        if ($this->isLoggedIn()) {

            $posts = $this->db->showPosts();
            $this->view->render('posts', ['posts' =>$posts]);
        } else {
            header("Location: /login");
            exit();
        }
    }
    public function removePost() {

        if(isset($_GET['remove'])) {
            $postID = $_GET['remove'];
            // Pobierz ścieżkę do zdjęcia powiązanego z wpisem
            $photo_path = $this->db->getPostPhotoPath($postID);
            
            // Usuń wpis z bazy danych
            $success = $this->db->removePostFromDatabase($postID);
            if($success) {
                // Jeśli usunięto wpis, usuń również powiązane zdjęcie z serwera
                if(!empty($photo_path) && file_exists($_SERVER['DOCUMENT_ROOT'] . $photo_path)) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $photo_path);
                }
                header('Location: /posts');
                exit();
            } else {
                echo "Nie udało się usunąć wpisu";
            }
        } else {
            echo "Wystąpił błąd podczas usuwania wpisu";
            exit();
        }
    }

    public function renderEditPost($postID) {
        if(isset($_GET['edit']))
        {
            $postID = $_GET['edit'];
            $post = $this->db->showEditPost($postID);
            
             $this->view->render('editPost',['post' => $post]);
        }
    }

    public function editPost($postID) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $sciezka = $_POST['sciezka'];
            $content = $_POST['content'];
            
            // Pobierz aktualną ścieżkę zdjęcia
            $old_photo_path = $this->db->getPostPhotoPath($postID);
    
            // Sprawdź, czy zostało przesłane nowe zdjęcie
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Usuń stare zdjęcie z serwera, jeśli istnieje
                if(!empty($old_photo_path) && file_exists($_SERVER['DOCUMENT_ROOT'] . $old_photo_path)) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $old_photo_path);
                }
    
                // Przenieś nowe zdjęcie na serwer
                $upload_dir = __DIR__ . '/../../public/photos/'; 
                $photo_name = $_FILES['photo']['name'];
                $photo_path = '/public/photos/'. $photo_name;
                $upload_path = $upload_dir . $photo_name;
                move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path);
            } else {
                // Jeśli nie ma nowego zdjęcia, zachowaj istniejącą ścieżkę
                $photo_path = $old_photo_path;
            }
    
            // Aktualizuj wpis w bazie danych
            $this->db->editPostInDatabase($postID, $title, $content, $sciezka, $photo_path);
            
            // Przekieruj użytkownika z powrotem do listy postów
            header("Location: /posts");
            exit();
        }
    }
}

?>