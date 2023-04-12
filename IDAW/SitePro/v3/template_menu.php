<?php
function renderMenuToHTML($currentPageId,$currentLang) {
// un tableau qui d\'efinit la structure du site

$mymenu = array(
// idPage titre
'accueil' => array( 'Accueil' ),
'cv' => array( 'Cv' ),
'projets' => array('Mes Projets'),
'contact' => array('Contact')
);
$lang = array(
    'en' => array('Anglais'),
    'fr' => array('Francais')


);

// ...
echo "<ul class='navbar-nav text-uppercase ms-auto py-4 py-lg-0'> ";
echo " <nav class='navbar navbar-expand-lg navbar-dark fixed-top ' id='mainNav'>";
echo" <div class='container'>";
foreach($mymenu as $pageId => $pageParameters) {
    if($pageId==$currentPageId) {
    
        echo "<li class='nav-item'> <a class='nav-link' id='currentPage' href='index.php?page={$pageId}&langue={$currentLang}'>{$pageParameters[0]} </a></li> <br>";
    }

    else
    {

    
        echo " <li class='nav-item'> <a class='nav-link' href='index.php?page={$pageId}&langue={$currentLang}'>{$pageParameters[0]} </a></li> <br>";
    }
}
echo"<li class='deroulant'>Langue";
echo"<ul class='sous'>";
foreach($lang as $pagelang => $langParameters) {
    echo "<li> <a  href='index.php?page={$currentPageId}&langue={$pagelang}'>{$langParameters[0]} </a></li> <br>";
}
echo"</ul>";
echo "</li>";
echo "</ul> ";
echo "</div>";
echo "</nav>";
// ...
}
?>