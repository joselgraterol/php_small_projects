<?php  

require_once 'model/UserModel.php';
require_once 'view/userView.php';

class UserController {
   private $model;
   private $view;

   public function __construct() {
       $this->model = new UserModel("John Doe", "john.doe@example.com");
       $this->view = new UserView();
   }

   public function showUser() {
       return $this->view->output($this->model);
   }
}



?>