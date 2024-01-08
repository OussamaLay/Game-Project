<html>
    <head>
        <title>JEUX VIDEOS</video></title>
        <link rel="stylesheet" href="styles.css" type="text/css">
    </head>
    <body>
        <div class="page">

            <!-- le bloc qui contient le titre  -->
            <div class="titre">
                <div class="titre_logo"><img src="img_site/icone-site.gif"></div>
                <h1 class="titre-1">JEUX VIDÉOS</h1>
            </div>

            <!-- le bloc qui contient l'authentification -->
            <div class="authentification">
                <div class="login">
                    <label style="font-family: calibri" for="adresse_mail">adresse mail</label>
                    <input type="text" name="mail" id="mail">
                    <label style="font-family: calibri" for="mdp">mot de passe</label>
                    <input type="password" name="mdp" id="mdp">
                </div>
                <div class="bouton_center">
                    <button class="bouton">S'INSCRIRE</button>
                    <button class="bouton">CONNEXION</button>
                </div> 
            </div>

            <!-- le bloc qui contient le contenu dynamique du site; peut contenir  {categorie, liste des articles de chaque catégorie} -->
            <div class="contenu">
                <?php
                    #$db = seconnecter("localhost", "jeux-videos", "IsImA_2023/%", "jeux_videos", 3307);
                    $db = seconnecter("localhost", "postgres", "S0314", "jeux-videos", 5432);
                    if(isset($_GET['categorie'])) {
                        $categorie = $_GET['categorie'];
                        $categories = ['sport', 'combat', 'horreur', 'simulation', 'aventure'];
                        if(in_array($categorie, $categories)) {
                            afficher_articles_par_categorie($db, $categorie);
                        }
                    } else {
                        afficher_categories($db);
                    }
                    se_deconnecter($db);
                ?>
            </div>
            
            <!-- le bloc qui contient le panier dynamique -->
            <div class="panier">
                <div class="panier_conteneur">
                    <div class="panier_titre">
                        <img src="img_site/caddie.gif">
                        <div class="panier_titre_texte">votre panier</div>
                    </div>
                    <hr>
                    <?php
                        $db = seconnecter("localhost", "postgres", "S0314", "jeux-videos", 5432);
                        if(isset($_POST['vider_panier'])){
                                supprimePanier($db);
                                if (!panierNonVide($db)){
                                    echo '<div class="article_text"></div>';   
                                    echo '<div class="prix_text"></div>';
                                    echo '<hr>';
                                    echo '<div class="prix_text" id="total" ></div>';      
                                }
                        }
                        afficherPanier($db);
                        se_deconnecter($db);
                        ?>
                </div>
            </div>
        </div>
    </body>
</html>

<!-- le bloc qui contient les fonctions pour le traitement de site -->

<link rel="stylesheet" href="style.css" type="text/css">
<?php 

    //fonction qui se connecte à la base de données 
    //function seconnecter($nom_host, $nom_util, $mdp, $bdd, $port){
    //    $db = mysqli_connect($nom_host, $nom_util, $mdp, $bdd, $port) or die("Error SQL:".mysqli_error($db)); // se connecter à la base 
    //    $db -> query("SET NAMES UTF8");
//
    //    return $db; // On retourne un pointeur vers la base de données
    //}
    function seconnecter($nom_host, $nom_util, $mdp, $bdd, $port) {
        try {
            $db = new PDO("pgsql:host=$nom_host;port=$port;dbname=$bdd;user=$nom_util;password=$mdp");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch(PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            return null;
        }
    }
    
    // fonction qui se deconnecte de la base de données
    function se_deconnecter($db){
        $db = null;
    }    


    // fonction qui affiche les differents catégories existantes depuis un base de données 
    function afficher_categories($db){
        $sql = "SELECT * FROM categorie"; // Requête SQL pour récupérer les catégories
        $resultat = $db->query($sql); // Exécute la requête --> la ligne 108
        
        echo '<div class="grid1">';
        // Boucle pour afficher les catégories dans la première grille (grid1)
        for ($i=1; $i<=3; $i++){
            $table = $resultat->fetch(PDO::FETCH_ASSOC); // Récupère une ligne de résultat sous forme de tableau associatif
            if (!$table) break; // Arrête la boucle s'il n'y a plus de lignes
    
            $libelle = $table['libelle'];
            // Détermine le préfixe "JEUX D'" ou "JEUX DE" en fonction de la première lettre de la catégorie
            $articlePrefix = (in_array(strtolower($libelle[0]), ['a', 'e', 'i', 'o', 'u','h'])) ? 'JEUX D\'' : 'JEUX DE';
            $html  = '<div class="cat">';
            $html .= '<div class="cadre"><a href="index.php?categorie='.$libelle.'"><img src="img_categories/'.$table['image'].'"></a></div>';
            $html .= '<label for="'.$libelle.'">'.$articlePrefix.'<br>'.$libelle.'</label>';
            $html .= '</div>';
            echo $html;
        }
        echo '</div>';
    
        echo '<div class="grid2">';
        // Boucle pour afficher les catégories dans la deuxième grille (grid2)
        for ($i=1; $i<=2; $i++){
            $table = $resultat->fetch(PDO::FETCH_ASSOC); // Récupère une ligne de résultat sous forme de tableau associatif
            if (!$table) break; // Arrête la boucle s'il n'y a plus de lignes
    
            $libelle = $table['libelle'];
            // Détermine le préfixe "JEUX D'" ou "JEUX DE" en fonction de la première lettre de la catégorie
            $articlePrefix = (in_array(strtolower($libelle[0]), ['a', 'e', 'i', 'o', 'u','h'])) ? 'Jeux d\'' : 'Jeux de';
            $html  = '<div class="cat">';
            $html .= '<div class="cadre"><a href="index.php?categorie='.$libelle.'"><img src="img_categories/'.$table['image'].'"></a></div>';
            $html .= '<label for="'.$libelle.'">'.$articlePrefix.'<br>'.$libelle.'</label>';
            $html .= '</div>';
            echo $html;
        }
        echo '</div>';
    }
    

    function afficher_articles_par_categorie($db, $categorie){
        // Requête SQL pour récupérer tous les articles d'une catégorie spécifique
        $sql = "SELECT * FROM article WHERE id_categorie = (SELECT id FROM categorie WHERE libelle = :categorie)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->execute();
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $i=0;
        // Bouton de retour vers la page principale
        echo '<a href="index.php"><button class="bouton">RETOUR</button></a>';
        // Conteneur pour les articles avec possibilité de défilement
        echo '<div class="scrolleur">';
    
        // Boucle pour afficher chaque article
        foreach ($resultat as $table) {
            $i+=1;
            $html  = '<div class="jeux_conteneur">';
            $html .= '<div class="jeux"><img src="img_articles/'.$table['image'].'"></div>';
            $html .= '<div class="infos">';
            $html .= '<div class="partie_info">';
            $html .= '<div class="nom_jeu">'.$table['libelle'].'</div>';
            $html .= '<div class="info_jeu">'.$table['detail'].'</div>';
            $html .= '<div class="prix_jeu"><span style="line-height:40px">'.$table['prix_ttc'].' €</span></div></div>';
            // Formulaire pour commander l'article
            $html .= '<form method="post"><div class="prtie_commander"><input type="submit" name="commander'.$i.'" class ="bouton" value="COMMANDER"/></div></form>';
            $html .='</div></div>';
            echo $html;
    
            // Vérification si le bouton "COMMANDER" a été cliqué
            if(isset($_POST['commander'.$i])) {
                // Appel de la fonction pour ajouter l'article au table panier_article
                ajouterArticle($db, $table['id'], $i, $table['prix_ttc']);
            }
        }
    
        echo '</div>';
    }
    
    


    function ajouterArticle($db, $id_article, $quantite, $prixProduit) {
        // Requête pour vérifier si l'article existe déjà dans le panier
        $sql_check = "SELECT COUNT(*) AS count_articles FROM panier_article WHERE id_article = :id_article";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->bindParam(':id_article', $id_article);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
        $nombre_articles = $row['count_articles'];
    
        if ($nombre_articles > 0) {
            // L'article existe déjà, donc incrémenter la quantité
            $sql_increment = "UPDATE panier_article SET quantite = quantite + 1 WHERE id_article = :id_article";
            $stmt_increment = $db->prepare($sql_increment);
            $stmt_increment->bindParam(':id_article', $id_article);
            $stmt_increment->execute();
        } else {
            // L'article n'existe pas, donc l'ajouter au panier avec une quantité initiale de 1
            $sql_insert = "INSERT INTO panier_article VALUES (:id_article, 1, 0, 0, :prixProduit)";
            $stmt_insert = $db->prepare($sql_insert);
            $stmt_insert->bindParam(':id_article', $id_article);
            $stmt_insert->bindParam(':prixProduit', $prixProduit);
            $stmt_insert->execute();
        }
    }
    


    function afficherPanier($db){
        // Requête SQL pour récupérer les informations de la table panier_article et lier les articles correspondants dans la table article 
        $sql = "SELECT * FROM panier_article JOIN article ON id_article=id";
        $resultat = $db->query($sql);
        
        // Vérifie si le panier n'est pas vide
        if ($resultat->rowCount() > 0) {
            // Conteneur avec possibilité de défilement pour afficher les articles du panier
            echo '<div class="panier_scroller">';
            
            // Boucle pour afficher chaque article dans le panier
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                // Utilisation des données de chaque ligne de la table pour afficher les détails de l'article
                $produit = $row['libelle'];
                $quantiteProduit = $row['quantite'];
                $prixProduit = $row['prix_ttc'];
                
                // Affichage du nom de l'article et le calcul du prix total pour cet article
                echo '<div class="article_text">'.$produit.'</div>';
                echo '<div class="prix_text">'.$quantiteProduit.' x '.$prixProduit.' = '.(floatval($quantiteProduit) * floatval($prixProduit)).' €</div>';
            }
    
            echo '</div>';
    
            // Affichage du total du prix du panier
            TotalPrix($db);
    
            // Formulaire pour vider le panier
            echo '<form style="display: flex; justify-content: center;" method="post"><input type="submit" name="vider_panier" class ="bouton" value="VIDER LE PANIER"/></form>';
        }
    }
    
    
    function panierNonVide($db) {
        // Requête SQL pour compter le nombre d'articles dans le panier
        $sql = "SELECT COUNT(*) AS count_articles FROM panier_article";
        $stmt = $db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Retourne vrai si le nombre d'articles dans le panier est supérieur à 0, sinon retourne faux
        return ($row['count_articles'] > 0);
    }
    
    
    
    function supprimePanier($db) {
        // Requête SQL pour supprimer tous les articles du panier
        $sql = "DELETE FROM panier_article";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    
    
    
    function TotalPrix($db) {
        // Requête SQL pour obtenir la somme des prix des articles dans le panier
        $sql = "SELECT SUM(prix_ttc) as total FROM panier_article";
        $stmt = $db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Récupération du résultat de la requête
        $total = $row['total'];
    
        // Affichage du séparateur horizontal et du montant total du panier
        echo '<hr>';
        echo '<div class="prix_text" id="total" >TOTAL : '.$total.' €</div>';
    }     
?>