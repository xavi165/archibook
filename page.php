
<?php
//session_start();


if(isset($_GET['id']) /*AND $_GET['id'] > '0'*/) {
   $bdd = new PDO('mysql:host=localhost:8889;dbname=archibook', 'root', 'root');    
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
    
    $ldaphost = "ldap.forumsys.com";  // votre serveur LDAP
    $ldapport = 389;
    $ldaprdn= "cn=read-only-admin,dc=example,dc=com";
    $ldappass= "password";
    
    $ldapconn = ldap_connect($ldaphost, $ldapport) or die("Impossible de se connecter au serveur LDAP $ldaphost");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    if ($ldapconn) {
 
	// Connexion au serveur LDAP
	   $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
 
	// Vérification de l'authentification
	   if ($ldapbind) {
		  //echo "Connexion LDAP réussie...";
	   }   else {
		  echo "Connexion LDAP échouée...";
	   }
 
    }    
    //$dn = "cn=read-only-admin,dc=example,dc=com";
    //$dn = "cn=read-only-admin,ou=scientists,dc=example,dc=com";
    //$dn = "dc=example,dc=com";
    $dn = "dc=example,dc=com";
    //$filter="OU=****,DC=****,DC=***";

    
    //$dn="CN=CEFF,DC=DOM";
    $filter="(ou=*)";
    //$filter="(&(objectClass=*)(objectCategory=*)(sn=*))";
    $filter="(|(sn=*))";
    //$justthese = array("sn", "mail");
    //$sr=ldap_search($ldapconn, $dn, $filter,$justthese);
    $sr=ldap_search($ldapconn, $dn, $filter);
    $info = ldap_get_entries($ldapconn, $sr);
  
 
    $infoLDAP = ldap_get_entries($ldapconn, $sr);
    
    ldap_close($ldapconn);
    /*
     for($i=0; $i<count($infoLDAP) ; $i++)
        {
         echo $i; echo " ==>   ";
         if (isset($infoLDAP[$i]["cn"])) {
          echo($infoLDAP[$i]["cn"][0]);
          if (isset($infoLDAP[$i]["mail"])) {
            echo " mail :   ";
            echo($infoLDAP[$i]["mail"][0]);
            }
         }
          echo '<br>';
              
        }*/

}
;

?>
<html>
<link href="style.css" rel='stylesheet' type='text/css'>
   <head>
      <title>Archibook - Votre profil</title>
      <meta charset="utf-8">
   </head>
   <body>
       <header>
    <table>
            <tr>
                <td width='100%' align='left'>
                    <img src= "http://localhost:8888/archibook-master/img/logoisep.png" width='180px' align='center' alt="Logo entreprise"/>
                </td>
                
                <td width='100%' align='right'>
                    <a href="deconnexion.php">
                       <input type="button" value="Se déconnecter" style="border: solid 2px #919191; padding:10px 3px 10px 3px; border-radius:8px; background:'white'; font:bold 13px Arial; color:#1B019B;" />
                    </a>
                </td>
            </tr>
        
    </table>
      </header> 
    <div align="center"> 
    <div style="width: 500px; padding-top: 15px; padding-bottom: 15px; border: 3px solid #1B019B; text-align: center; background: white;border-radius: 10px;" align='center'>
       <table align="center">
            
            <tr>
                <td align ="center">
                    <h2>Bienvenue sur ton profil <?php echo $userinfo['username']; ?> ! </h2>
                </td>
            </tr>
           <tr>
                <td>
                    <B>Voici tes infos : </B><br><br>
                </td>       
            </tr>
            <tr>
                <td>
                    Pseudo = <?php echo $userinfo['username']; ?>
                </td>       
            </tr>
            <tr>
                <td>
                    Mail = <?php echo $userinfo['mail']; ?>
                </td>
             </tr>   
            <tr>
                <td>
                    <br><B>Voici tous tes camarades :</B><br>
                    <br><br>
                    <?php
                    
                       for($i=0; $i<count($infoLDAP) ; $i++)
                        {
                            if (isset($infoLDAP[$i]["cn"])) {
                                echo($infoLDAP[$i]["cn"][0]);
                                if (isset($infoLDAP[$i]["mail"])) {
                                    echo " <b>mail :</b>   ";
                                    echo($infoLDAP[$i]["mail"][0]);
                                    }
                                }
                            echo '<br>';
              
                        }
                    ?>
                </td>
            </tr>
       </table>
    </div>
    </div>
    <footer align="left">
            <p style="color='red';"><I>Archibook</I></p>
        <p style="text-align:right;"><a href="">Conditions d'utilisation</a>
        </p>
    </footer>   
   </body>
</html>
<?php   

?>