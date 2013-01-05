<?php
  require_once( "User.php");

  class Admin extends User{
    public static $_adminList = array();
  
   ############## Overriding methods ########################
  
    public static function signUp($firstName, $lastName, $password, $birthDate, $country, $email) {
      if(count(User::$_signedUpUsers) < User::$num2){
        ##$newUser = new User ($firstName, $lastName, $password, $birthDate, $country, $email);
        $newUser= new Admin();
        $newUser->setFirstName($firstName);
        $newUser->setLastName($lastName);
        $newUser->setPassword($password);
        $newUser->setBirthDate($birthDate);
        $newUser->setCountry($country);
        $newUser->setEmail($email);
        $newUser->setUserName();
        
        Admin::$_adminList[] = $newUser;
        User::$_signedUpUsers[] = $newUser;
        
        return  $newUser;
        }else {
          return false;
        }
    }
    
   
    
     public function setUserName(){
      
      $string1= strtoupper(substr($this->_firstName, 0, 3)); 
      $string2= strtoupper(substr($this->_lastName, 1, 2));
      
      $string3 = substr_replace($this->_firstName, $string1, 0, 3);
      $string4 = substr_replace($this->_lastName, $string2, 1, 2);
      
      $username = "admin_"."$string3"."$string4";
      
      $this->_username = $username;
     
    
     }
     
     ############## Another methods #########################
    
     // Elimina usuario dado su nombre de usuario y su password
     public static function deleteUser($username, $password){
        
        foreach (User::$_signedUpUsers as $user){
          if($user->getUserName() == $username && $user->getPassword() == $password) {
            $index= key(User::$_signedUpUsers)-1;                                                                                                              
            array_splice ( User::$_signedUpUsers, $index, 1);
            break;
          }
        }
        
         foreach (User::$_loggedUsers as $user1){
          if($user1->getUserName() == $username && $user1->getPassword() == $password) {
            $index1= key(User::$_loggedUsers)-1;                                                                                                              
            array_splice ( User::$_loggedUsers, $index1, 1);
            break;
          }
        }
      
      }
      
      
      // Cierra sesión de usuario dado su nombre de usuario y su password
      public function logoutUser($username, $password){
      
         foreach (User::$_loggedUsers as $user){
          if($user->getUserName() == $username && $user->getPassword() == $password) {
            $index= key(User::$_loggedUsers)-1;                                                                                                              
            array_splice ( User::$_loggedUsers, $index, 1);
            break;
          }
        }
      
      }
      
      
      // Cierra la sesión de todos los usuarios.
      public function logoutAll(){
      
      array_splice(User::$_loggedUsers, 0);
      
      }
      
      
      public function loggedUsersList () {
        
        foreach (User::$_loggedUsers as $user) {
          echo $user->getFirstName() . " " . $user->getLastName() ."</br>";
          echo $user->getUserName() . "</br>";
          echo $user->getPassword() . "</br></br></br>";
        }
      
      
      }
      
      

  }
  
  
  


?>
