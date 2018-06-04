<?php
session_start();
if(isset($_POST['formconnexion'])) {
$bdd = new PDO('mysql:host=localhost:8889;dbname=archibook', 'root', 'root');
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = htmlspecialchars($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE mail = ? AND mdp = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['username'] = $userinfo['username'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: page.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } 
}
?>


<html>
<link href="style.css" rel='stylesheet' type='text/css'>
   <head>
      <title>Archibook</title>
      <meta charset="utf-8">
   </head>
    
   <body style='background:white'>
       <header>
    <table >
            <tr>
                <td  align='left'>
                    <img src= "http://localhost:8888/archibook-master/img/logoisep.png" width='180px' align='center' alt="Logo entreprise"/>
                </td>
            </tr>
        
    </table>
      </header> 
       <div align="center">
       <div style="width: 300px; padding-top: 15px; padding-bottom: 15px; border: 3px solid #1B019B; text-align: center; background: white;border-radius: 10px;" align='center'>
           
      
         <h1>Connexion à Archibook !</h1>
        <h3><I>Connectez-vous avec les ID de votre école</I></h3>
         
         <form method="POST" action="">
            <input type="email" name="mailconnect"  value="email" onFocus="field_focus(this, 'email');" onblur="field_blur(this, 'email');" class="email" />
            <input type="password" name="mdpconnect" value="email" onFocus="field_focus(this, 'email');" onblur="field_blur(this, 'email');" class="email" />
            <br /><br />
             
            
             <input type="submit" name='formconnexion' value="Se connecter!" style="border: solid 2px #1B019B; padding:10px 3px 10px 3px; border-radius:8px; background:'white'; font:bold 13px Arial; color:#1B019B;" />
         </form>

          
         <?php
         if(isset($erreur)) {
            echo '<br /><br /><br /><br /><font color="red">'.$erreur."</font>";
         }
         ?>
         
      </div>
    </div>
   </body>
    <footer align="left">
        <p style="color='red';"><I>Archibook</I></p>
        <p style="text-align:right"><a href="">Conditions d'utilisation</a>
        </p>
    </footer>
</html>

<script src="script.js" type="text/javascript"></script>