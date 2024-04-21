<?php  

class UserView {
   public function output(UserModel $user) {
       return "<p>Name: " . $user->getName() . "</p>" .
             "<p>Email: " . $user->getEmail() . "</p>";
   }
}



?>