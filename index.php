<?php

session_start();

if (isset($_POST['email']))
{
 
  //Udana walidacja? Załóżmy, że tak!
  $wszystko_OK=true;
  
  //Sprawdź poprawność nickname'a
  $nick = $_POST['name'];
  
  //Sprawdzenie długości nicka
  if ((strlen($nick)<3) || (strlen($nick)>20))
  {
    $wszystko_OK=false;
    $_SESSION['e_nick']="Imię musi posiadać od 3 do 20 znaków!";
  }
  
  
  // Sprawdź poprawność adresu email
  $email = $_POST['email'];
  $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
  
  if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
  {
    $wszystko_OK=false;
    $_SESSION['e_email']="Podaj poprawny adres e-mail!";
  }
  
      
      $massage = $_POST['massage'];
      if ((strlen($massage)<3) || (strlen($massage)>10000))
  {
    $wszystko_OK=false;
    $_SESSION['e_massage']="Wiadomość jest zbyt krótka.";
  }
  $ip = $_SERVER['REMOTE_ADDR'];

  //Zapamiętaj wprowadzone dane
  $_SESSION['fr_nick'] = $nick;
  $_SESSION['fr_email'] = $email;
  $_SESSION['fr_massage'] = $massage;
  
      
      // Podajesz adres email na który chcesz otrzymać wiadomość
      $dokogo = "email@gmail.com";

      if ($wszystko_OK==true)
      {
      // Podajesz tytuł jaki ma mieć ta wiadomość email
      $tytul = "Form";

      // Przygotowujesz treść wiadomości
      $wiadomosc = "";
      $wiadomosc .= "Imie i nazwisko: " . $nick . "\n";
      $wiadomosc .= "E-mail kontaktowy: " . $email . "\n";
      $wiadomosc .= "Wiadomość: " . $massage . "\n";
      $wiadomosc .= "Ip: " . $ip . "\n";

      // Wysyłamy wiadomość
      $sukces = mail($dokogo, $tytul, $wiadomosc);

      // Przekierowywujemy na potwierdzenie
      if ($sukces){
        $wyslano = "Wiadomość została wysłana";   
      }
      else{
        $error = "Error. Coś się zepsuło.";
      }
      }
  
}	
?>
<!DOCTYPE html>
<html lang="en" >
<head>

  <meta charset="UTF-8">
  <title>Form || Validation in PHP</title>
 
      <link rel="stylesheet" href="css/style.css">

</head>
<body>

  <div id="form-main">
  <div id="form-div">
    <form class="form" id="form1" method="post">
      
      <p class="name">
        <input name="name" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Name" id="name" value="<?php
                                    if (isset($_SESSION['fr_nick']))
                                    {
                                        echo $_SESSION['fr_nick'];
                                        unset($_SESSION['fr_nick']);
                                    }
                                ?>" />

        <?php
                                    if (isset($_SESSION['e_nick']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                                        unset($_SESSION['e_nick']);
                                    }
                                ?>
      </p>
      
      <p class="email">
        <input name="email" type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Email" 
        value="<?php
                                    if (isset($_SESSION['fr_email']))
                                    {
                                        echo $_SESSION['fr_email'];
                                        unset($_SESSION['fr_email']);
                                    }
                                ?>" name="email" />

                                        <?php
                                    if (isset($_SESSION['e_email']))
                                    {
                                        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                                        unset($_SESSION['e_email']);
                                    }
              ?>

      </p>
      
      <p class="text">
        <textarea name="massage" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="Comment"><?php
                                    if (isset($_SESSION['fr_massage']))
                                    {
                                        echo $_SESSION['fr_massage'];
                                        unset($_SESSION['fr_massage']);
                                    }
                                        ?></textarea>
                                        <?php
                                        if (isset($_SESSION['e_massage']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_massage'].'</div>';
                                            unset($_SESSION['e_massage']);
                                        }
                                       ?>
      </p>
      
      
      <div class="submit">
        <input type="submit" value="SEND" id="button-blue"/>
        <div class="ease"></div>
      </div>
      <?php 
        echo '<div class="good">'.$wyslano.'</div>';
      ?>
       <?php 
        echo '<div class="good">'.$error.'</div>';
      ?>
    </form>
  </div>
  
  

</body>

</html>
