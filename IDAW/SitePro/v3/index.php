
<?php
require_once("template_header.php");
require_once("template_menu.php");
$currentPageId = 'accueil';
$currentLang = 'fr';
if(isset($_GET['page'])) {
$currentPageId = $_GET['page'];
}
if(isset($_GET['langue'])) {
    $currentLang = $_GET['langue'];
    }
?>

<?php
renderMenuToHTML($currentPageId,$currentLang);
?>
<section class="corps">
<?php
$pageToInclude = $currentLang."/". $currentPageId . ".php";
if(is_readable($pageToInclude))
require_once($pageToInclude);
else
require_once("error.php");
?>
</section>
<?php
require_once("template_footer.php");
?>