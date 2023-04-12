<?php
function renderMenuToHTML($currentPageId) {
// un tableau qui d\'efinit la structure du site

$mymenu = array(
// idPage titre
'index' => array( 'Accueil' ),
'cv' => array( 'Cv' ),
'projets' => array('Mes Projets')
);
// ...
echo "<ul class='navbar-nav text-uppercase ms-auto py-4 py-lg-0'> ";
foreach($mymenu as $pageId => $pageParameters) {
    if($pageId==$currentPageId) {
    
        echo "<li class='nav-item'> <a class='nav-link' id='currentPage' href='{$currentPageId}.php'>{$pageParameters[0]} </a></li> <br>";
    }

    else
    {

    
        echo " <li class='nav-item'> <a class='nav-link' href='${pageId}.php'>{$pageParameters[0]} </a></li> <br>";
    }
}
echo "</ul> ";
// ...
}
?>