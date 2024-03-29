<?php
  require_once( "Admin.php");

  class User{
  
    protected $_firstName;
    protected $_lastName;
    protected $_username;
    protected $_password;
    protected $_birthDate;
    protected $_country;
    public static $countryList = array("venezuela" => "venezuela", "cuba" => "cuba", "italia" => "italia", "mexico" => "mexico");
    protected $_email;
    //public static $users = array();
    public static $_signedUpUsers = array();
    public static $_loggedUsers = array(); 
    const NUM = 5;
    public static $num2 = 20;
  
  ############# Constructor ##############
  /*
  public function __construct ($firstName, $lastName,$password, $birthDate, $country, $email){
  
  $this->_firstName = $firstName;
  $this->_lastName = $lastName;
  $this->_password = $password;
  $this->_birthDate = $birthDate;
  $this->_country = $country;
  $this->_email = $email;
  
  }
  */
  
  ########### SET & GET ################
  
  
  // First Name
  public function getFirstName(){
  
        return $this->_firstName;
    
  }
  
  public function setFirstName($name){
  
    $name = ucfirst($name);
    $name = trim($name);
    
    if ( strpbrk( $name, "1234567890!*@_-$" ) || ( $name == "user")  || ( $name == "admin")) {
      echo "El nombre solo debe incluir letras, ademas no debes usar 'user' o 'admin'";
    }
    if ( strlen($name) < 5 || strlen($name) > 10) {
      echo "tu nombre debe contener por lo menos 5 letras y maximo 10";
    } else { 
        $this->_firstName = $name;
    }
    
  }

  // Last Name
  
  public function getLastName(){
   
        return $this->_lastName;
    
  }
  
  public function setLastName($lastname){
  
    $lastname = ucwords($lastname);
    $lastname = trim($lastname);
    if ( strpbrk( $lastname, "1234567890!*@_-$" ) ||( $lastname == "user")  || ( $lastname == "admin")){
      echo "El apellido solo debe incluir letras, ademas no debes usar 'user' o 'admin'";
    }
    
    if ( strlen($lastname) < 5 || strlen($lastname) > 10) {
      echo "tu apellido debe contener por lo menos 5 letras y maximo 10";
    } else {
        $this->_lastName = $lastname;
    }
    
  }
 
  
 
  
  // Password
  
  public function getPassword(){
  
  return $this->_password;
  
  }
  
  public function setPassword($password){
  
    if ( strlen ($password) < 5 || strlen ($password) > 10){
      echo "Tu contraseña debe tener por lo menos 5 digitos, pero no mas que 10";
    } else{
    $this->_password = $password;
    }
  
  }
  
  public function getBirthDate(){
  
  return $this->_birthDate;
  
  }
  
  public function setBirthDate($birthDate){
  $this->_birthDate = $birthDate;
  }
  
 
  // Pais
  
  public function getCountry(){
  
  return $this->_country;
  
  }
  
  public function setCountry($country){
  
   if( array_key_exists ( $country , User::$countryList)) {
   
     $this->_country = $country;
   
   }else{
      echo "el pais no existe";
   }
  
  }
  
  public function getEmail(){
  
  return $this->_email;
  
  }
  
  public function setEmail($email){ 
    
    //Verifico que haya un solo arroba "@" y un solo punto "." en el string $email
    if(substr_count($email, "@") == 1 && substr_count($email, ".") == 1){
      //verifico que lo que esté antes del arroba "@" sea mayor o igual a 3 y que desde el punto "." hasta el final del string hayan exactamente cuatro caracteres (tomando en cuenta el punto).
      if( strpos($email, "@") >= 3 && strlen(strstr($email, ".")) == 4 ){
        $this->_email = $email;
      }
    }else{
        echo "Maldita sea, coloca bien tu correo, debe ser algo como esto: ejemplo@hotmail.com";
    }
 
  }
  
    public function getUserName(){
  
      return $this->_username;
  
    }
    
    public function setUserName(){
  
      $string1= strtoupper(substr($this->_firstName, 0, 3)); 
      $string2= strtoupper(substr($this->_lastName, 1, 2));
      /*
      $string3= $this->_firstName;
      $string4= $this->_lastName;
      */
      
      $string3 = substr_replace($this->_firstName, $string1, 0, 3);
      $string4 = substr_replace($this->_lastName, $string2, 1, 2);
      
      $username = "$string3"."$string4";
      
      $this->_username = $username;
  
  }
  
  
  
  ############################################# Another Methods ###############################################################
  

  
  ##### Método para registrar usuarios #######
  public static function signUp($firstName, $lastName, $password, $birthDate, $country, $email) {
    if(count(User::$_signedUpUsers) < User::$num2){
      ##$newUser = new User ($firstName, $lastName, $password, $birthDate, $country, $email);
      $newUser= new User();
      $newUser->setFirstName($firstName);
      $newUser->setLastName($lastName);
      $newUser->setPassword($password);
      $newUser->setBirthDate($birthDate);
      $newUser->setCountry($country);
      $newUser->setEmail($email);
      $newUser->setUserName();
      
      
      User::$_signedUpUsers[] = $newUser;
     
      
      
      /*$users[] = array('firstname' => 'Maria', 'lastname' => 'Santaella', 'password' =>'13212', 'dob' => '04/10/1991', 'country' => 'venezuela', 'email' => 'ljkasdlkas');
      $users[] = array('firstname' => 'guillermo', 'lastname' => 'Sgjklsd', 'password' =>'132122', 'dob' => '04/10/1992', 'country' => 'venezuela', 'email' => 'aklsjjldkaskl');
      foreach ($users as $user) {
          $chapulines[] = new User($user['firstname'], $user['lastname'], $user['password'], $user['dob'], $user['country'], $user['email'] );
      }
      //$user1 = new User("Maria", "santaella", "2123jk", "04/10/1991", "venezuela");
      return $chapulines;*/
    
      return  $newUser;
     } else {
      return false;
      }
    
  }
  
  ############### Método para logear usuario ################
  public static function login($username, $password){
  
    if(count(User::$_loggedUsers) < User::NUM){
      foreach (User::$_signedUpUsers as $user){
        if ($user->getUserName() == $username && $user->getPassword() == $password){
          User::$_loggedUsers[] = $user; 
          return $user;
        }
      }
     }
       return false;
      
  }
  
  ##########  Método para cerrar sesión de usuario ############
  public function logout($username, $password){
  
      foreach (User::$_loggedUsers as $user){
          if($user->getUserName() == $username && $user->getPassword() == $password) {
            $index= key(User::$_loggedUsers)-1;                                                                                                              
            array_splice ( User::$_loggedUsers, $index, 1);
            break;
          }
        }
  }
  
  ######### Método para mostrar lista de usuarios alineada a la derecha #########
  public static function showUsersList() {
  
    foreach (User::$_signedUpUsers as $user){
     if( strstr($user->getUserName(), "admin_")){
      $string = str_pad( $user->getUserName(), 240, " ", STR_PAD_LEFT );
      $string = str_replace(" ", "&nbsp;", $string); 
      echo $string . "</br>";
      $string2 = str_pad( "Tipo: Administrador" , 240, " ", STR_PAD_LEFT );
      $string2 = str_replace(" ", "&nbsp;",$string2); 
      echo $string2 . "</br> </br>";
     }else{
      $string3 = str_pad( $user->getUserName(), 240, " ", STR_PAD_LEFT );
      $string3 = str_replace(" ", "&nbsp;", $string3); 
      echo $string3 . "</br>";
      $string4 = str_pad( "Tipo: Regular" , 240, " ", STR_PAD_LEFT );
      $string4 = str_replace(" ", "&nbsp;",$string4); 
      echo $string4 . "</br> </br>";
      } 
    }
    
  }
  
  ##### Método para devolver biografia de usuario ######
  public function showBio(){
      //falta agregarle la fecha de nacimiento
      $bio = "My name is " . $this->_firstName . "</br> I live in: " . $this->_country . "</br> My birthday is on: ". $this->_birthDate;
             
      return $bio;
  }
  
  ##### Método para devolver el nombre completo en mayúscula #####
  public function showCompleteName(){
  
    $name = strtoupper($this->_firstName);
    $last = strtoupper($this->_lastName);
    $complete = "$name " . "$last";
    return $complete;
    
  }
  
  ##### Método para devolver el país con la primera letra mayúscula ####
  public function showCountry(){
  
  return ucfirst($this->_country);
  
  }
  
  #### Método para devolver el email en minúsculas###
  public function showEmail(){

  return strtolower($this->_email);
  }
  
  public function showBirthDate(){
  
  }
  
  
  
  
  
 
 }

########## primeras pruebas de validación -Nada importante- ###########3
/*
$obj = new User();
$obj-> setFirstName("Giovanna ");
$obj-> setLastName("Russo");
$obj-> setPassword("12345ln");
$obj-> setCountry("mexico");

echo "el nombre de mi primer usuario es " . $obj->getFirstName() . "</br>";
echo "y el apellido es " . $obj->getLastName() . "</br>";
echo "mi jodida contraseña es " . $obj->getPassword() . "</br>";
echo "mi usuario es " . $obj->userName() . "</br>";
echo "mi pais es " . $obj->getCountry() . "</br>";
echo "nombre completo: " . $obj->showCompleteName() . "</br>";
echo "Pais de origen: " . $obj->showCountry() . "</br>";
echo "BIO </br>" . $obj->showBio();
echo "\n";      */

#########  Registro de usuarios regulares ###########
$user1= User::signUp("morela", "pacheco", "111222", "21/08/1960", "venezuela", "morela@hotmail.com"); 
$user2= User::signUp("Mireya", "marchani", "222555", "10/03/1943", "mexico", "mireyita@hotmail.com");  
$user3= User::signUp("Andreina", "franco", "111224", "21/12/1991", "cuba", "alex@hotmail.com"); 
$user4= User::signUp("maria", "santaella", "1111jj", "25/10/1991", "italia", "alex@hotmail.com"); 
$user5= User::signUp("Daniel", "Moreno", "2222jj", "04/08/1991", "mexico", "alex@hotmail.com");

######### Registro de administradores ############# 
$admin1= Admin::signUp("giovanna", "russo", "mika21", "08/07/1991", "venezuela", "giova@hotmail.com");
$admin2= Admin::signUp("alexis", "bravo", "123456", "06/05/1984", "mexico", "alex@hotmail.com");    

######### Login de usuarios ##########
//var_dump(count(User::$_loggedUsers) <= User::NUM);
$test1= User::login("admin_ALExisBRAvo","123456"); 
$test2= User::login("MORelaPACheco", "111222"); 
$test3= User::login("DANielMOReno", "2222jj"); 

$test4= User::login("MIReyaMARchani", "222555"); 
$test5= User::login("ANDreinaFRAnco", "111224"); 
$test6= User::login("MARiaSANtaella", "1111jj"); 
 

####### Prueba del login de usuario ###########        
/*
if(User::login("ALExisBRAvo", "5512jj") != false){
  echo "hola Alex";
} else {
  echo "incorrecto";

}
*/

########### Eliminar usuario -por admin unicamente- ########
//Admin::deleteUser("MORelaPACheco", "111222");


########### Cerrar sesión de usuario (logout) -por admin unicamente- ########
//Admin::logoutUser("MORelaPACheco", "111222");

########## Cerrar sesión de todos los usuarios -por admin unicamente- #########

//Admin::logoutAll();

##### muestra array de usuarios registrados ############
echo "<pre>";
echo print_r(User::$_signedUpUsers); 
echo "</pre>"; 


##### aqui cambio el valor de $num 2 #####
/*
User::$num2=52;
echo User::$num2;
*/

##### muestra array de usuarios logeados ############
/*echo "<pre>";
echo print_r(User::$_loggedUsers); 
echo "</pre>"; */




##### muestra array de administradores registrados ############
/*echo "<pre>";
echo print_r(Admin::$_adminList); 
echo "</pre>";
*/

########### Muestra una lista de usuarios logeados unicamente para administradores #######

//Admin::loggedUsersList();

########### Muestra lista de usuarios registrados, disponible para cualquiera -Alineado a la derecha-###########
//User::showUsersList();

########## Dado un usuario muestra: Biogafia, pais de origen, email ######## 

/*
$obj = User::login("ANDreinaFRAnco", "111224");
if ($obj != false){
  echo $obj->showBio(); //probar con showCountry(), showBio(), showEmail()
}else {
  echo "no tienes permisos para ver esta informacion";
}
*/


      
                                                                                
  
?>
