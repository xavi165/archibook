
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
   <head>
      <title>Archibook - Votre profil</title>
      <meta charset="utf-8">
   </head>
   <body>
       <header>
    <table align="center">
            <tr>
                <td width='70%' align='left'>
                    <img src= "http://localhost:8888/archibook-master/img/logoisep.png" width='180px' align='center' alt="Logo entreprise"/>
                </td>
                <td width='50%' align='right' color="red">
                    <input type="button" value="Se déconnecter" onClick="deconnexion.php"/>
                </td>
            </tr>
        
    </table>
      </header> 
    <div class="box"> 
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
       
   </body>
</html>
<?php   

?>