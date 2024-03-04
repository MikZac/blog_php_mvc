<?php

require_once("src/view.php");
require_once("src/Database.php");

class Controller {

    private $view;
    private $db;
    private $viewPost;
    public function __construct() {
        session_start();
        $this->view = new View();
        $this->db = new Database(require('config/config.php'));
        $this->viewPost = new View("templates/post/");
    }

    public function home() {
        $this->view->render('home');
    }

    public function blog() {

        $posts = $this->db->listingPost();
        $this->view->render('blog',['posts' => $posts]);
    }

    public function news() {
        $this->view->render('news');
    }

    public function kontakt() {
        $this->view->render('kontakt');
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = 'admin';
            if ($this->validateLogin($email, $password, $type)) {
                $_SESSION['email'] = $email;
                header("Location: /admin");
                exit();
            } else {
                header("Location: /login?error=invalid_login");
                exit();
            }
        } else {
            $this->view->render('login');
        }
    }

    private function validateLogin($email, $password, $type) {
        $user = $this->db->getUserByEmailAndPassword($email, $password, $type);
        if ($user !== false) {
            if ($user['type'] === 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function singlePost($postIdOrName) {
        $post = $this->db->getPostByIdOrName($postIdOrName);
        $this->viewPost->render('singlePost', ['post' => $post]);
    }
    
}

?>