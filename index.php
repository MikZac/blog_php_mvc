<?php
require_once('debug.php');
require_once('src/Controllers/Controller.php');
require_once('src/Controllers/AdminController.php');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$configuration = require_once('config/config.php');

$controller = new Controller();
$adminController = new AdminController();

switch ($path) {
    case '/':
        $controller->home();
        break;
    case '/blog':
        $controller->blog();
        break;
    case '/news':
        $controller->news();
        break;
    case '/kontakt':
        $controller->kontakt();
        break;
    case '/login':
        $controller->login();
        break;
    case '/admin':
        $adminController->admin();
        break;
    case '/add-user':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $adminController->renderAddUser();
        } else {
            $adminController->addUser();
        }
        break;
    case '/users':
        if(isset($_GET['remove'])) {
            
            $adminController->removeUser();
        } else if(isset($_GET['edit'])){
            $userID = $_GET['edit'];
            if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $adminController->renderEditUser($userID);
            } else {
                $adminController->editUser($userID);
            }
            
        } else {
            $adminController->users();
        }
        break;
    case '/add-post':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $adminController->renderAddPost();
        } else {
            $adminController->addPost();
        }
        break;
    case '/posts':
        {
            if(isset($_GET['remove'])) {
            
                $adminController->removePost();
            } else if(isset($_GET['edit'])){
                $postID = $_GET['edit'];
                if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    $adminController->renderEditPost($postID);
                } else {
                    $adminController->editPost($postID);
                }
            }
            else {
            $adminController->posts();
            }
        }
        break;
        default:
        // Sprawdzamy, czy ścieżka rozpoczyna się od '/blog/'
        if (strpos($path, '/blog/') === 0) {
            // Jeśli tak, to wywołujemy metodę singlePost w kontrolerze,
            // przekazując część adresu URL po '/blog/' jako identyfikator wpisu
            $postIdOrName = substr($path, strlen('/blog/'));
            $controller->singlePost($postIdOrName);
        } else {
            // W przeciwnym razie obsługujemy sytuację, gdy żądana strona nie istnieje
            echo "404 Not Found";
        }
        break;
}
?>