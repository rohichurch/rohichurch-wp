<?php
/**
 * Template 1 
 */
 
$page = cvg_lp_connect_public::get_setup();

?><!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page['page']['title']; ?> - <?php echo $page['opt']['_cvg_lp_connect_site_name']; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
    if ((isset($page['page']['desc'])) && (!empty($page['page']['desc'])))
    {
        echo '<meta name="description" content="'.$page['page']['desc'].'">'."\n";
    }
    
    if ((isset($page['page']['kw'])) && (!empty($page['page']['kw'])))
    {
        echo '<meta name="keywords" content="'.htmlspecialchars($page['page']['kw']).'">'."\n";
    }
?>
<meta name="og:title" content="<?php echo $page['page']['title']; ?>"/>
<meta name="og:site_name" content="<?php echo $page['opt']['_cvg_lp_connect_site_name']; ?>"/>
<?php
    if ((isset($page['page']['desc'])) && (!empty($page['page']['desc'])))
    {
        echo '<meta name="og:description" content="'.$page['page']['desc'].'">'."\n";
    }
    if ((isset($page['opt']['_cvg_lp_connect_lat'])) && (!empty($page['opt']['_cvg_lp_connect_lat'])))
    {
        echo '<meta name="og:latitude" content="'.$page['opt']['_cvg_lp_connect_lat'].'"/>'."\n";
    }
    if ((isset($page['opt']['_cvg_lp_connect_lng'])) && (!empty($page['opt']['_cvg_lp_connect_lng'])))
    {
        echo '<meta name="og:longitude" content="'.$page['opt']['_cvg_lp_connect_lng'].'"/>'."\n";
    }    
    if ((isset($page['opt']['_cvg_lp_connect_address'])) && (!empty($page['opt']['_cvg_lp_connect_address'])))
    {
        echo '<meta name="og:street-address" content="'.$page['opt']['_cvg_lp_connect_address'].'"/>'."\n";
    }   
    if ((isset($page['opt']['_cvg_lp_connect_locality'])) && (!empty($page['opt']['_cvg_lp_connect_locality'])))
    {
        echo '<meta name="og:locality" content="'.$page['opt']['_cvg_lp_connect_locality'].'"/>'."\n";
    }   
    if ((isset($page['opt']['_cvg_lp_connect_region'])) && (!empty($page['opt']['_cvg_lp_connect_region'])))
    {
        echo '<meta name="og:region" content="'.$page['opt']['_cvg_lp_connect_region'].'"/>'."\n";
    }   
    if ((isset($page['opt']['_cvg_lp_connect_postal_code'])) && (!empty($page['opt']['_cvg_lp_connect_postal_code'])))
    {
        echo '<meta name="og:postal-code" content="'.$page['opt']['_cvg_lp_connect_postal_code'].'"/>'."\n";
    }   
    if ((isset($page['opt']['_cvg_lp_connect_country'])) && (!empty($page['opt']['_cvg_lp_connect_country'])))
    {
        echo '<meta name="og:country-name" content="'.$page['opt']['_cvg_lp_connect_country'].'"/>'."\n";
    }  
    
    if (!isset($_GET['preview_mode']))
    {
        echo $page['opt']['_cvg_lp_connect_ga'];
    }
?>

<link rel="stylesheet" href="<?php echo $page['libd']; ?>/css/bootstrap.min.css" media="none" onload="if(media!='all')media='all'">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|Raleway|Roboto+Condensed" media="none" onload="if(media!='all')media='all'">
</head>
<body>

<div class="container-fluid" id="main">
    <div id="cvg-page-container" class="cvg-wp-connect <?php echo (isset($_GET['preview_mode']) && ($_GET['preview_mode'])) ? 'preview' : ''; ?>">
        <?php 
            // if we don't have pages to display
            if ($page['error'])
            {
                echo '
                    <div id="main-container">
                        <div id="header-text" class="row">
                            <h1>'.$page['page']['title'].'</h1>
                        </div>
                        <div id="top-text" class="row">
                            <p>'.$page['page']['desc'].'</p>
                        </div>
                        <div id="footer-text" class="row footer-text">
                            <p>'.sprintf(__('Copyright &copy %s, <a href="http://cvoutreach.com/">CV Outreach</a>. All rights reserved.', 'cvg-lp-connect'), date("Y")).'</p>
                        </div>
                    </div>
                ';
            }
            else
            {               
                echo $page['page']['content'];
            }
        ?>
    </div>
</div>

<script src="<?php echo $page['js_file']; ?>" type="text/javascript"></script>
<script src="<?php echo $page['libd']; ?>/js/jquery.min.js" type="text/javascript"></script>

<script>
document.addEventListener("DOMContentLoaded", function() 
{
    var el = document.getElementById('header-text');
    el.innerHTML = '<div id="header-text-wrap">'+el.innerHTML+'</div>';
});
</script>

<style>
<?php 
    echo cvg_lp_connect_public::css_str_replace("
* {
    font-family: Raleway, 'Roboto Condensed', sans-serif;
    color: rgb(".$page['tmpl']['txt_color'].");
    text-align: center;
}
body {  
    background-color: rgb(".$page['tmpl']['bg_color'].");
    ".((filter_var($page['tmpl']['bg_image'], FILTER_VALIDATE_URL) !== FALSE) ? "background-image: url(".$page['banner_image'].");" : "")."
}
.in-iframe #cvg-page-container.preview {
    margin-top: 0 !important;
}
#cvg_invitation {
    background-color: rgb(".$page['tmpl']['bg_color'].") !important;
}
#cvg_invitation #cvg_invitation_err {
    color: rgb(".$page['tmpl']['hl_color'].") !important;
}
#logo {
    padding: 15px 20px;
    max-height: 110px;
    max-width: 100%;
}
h1 {
    color: rgb(".$page['tmpl']['htxt_color'].");
    margin: 0px;
    font-size: 6em !important;
    padding-bottom: 20px;
    font-family: Montserrat, 'Roboto Condensed', cursive;
}
a {
    color: rgb(".$page['tmpl']['hl_color'].");
    text-decoration: none;
}
a:hover {
    color: rgb(".$page['tmpl']['hl_color'].");
    text-decoration: underline;
}
.small-top {
    transition: all .4s ease-in-out;
    width: 100% !important;
    left:0 !important;
    border-bottom-right-radius: 0px !important;
    border-bottom-left-radius: 0px !important;
}
.small-top #logo {
    max-height: 90px;
    padding: 10px 20px;
}
.large-top {
    max-height: 120px;
    transition: all .4s ease-in-out;
}
#cvg-page-container #main-container p {
    line-height: 1.25em;
}
#main-container {
    padding: 0px !important;
}
#header-text {
    background-size: cover;
    background-position: center;
    background-image: url(".$page['banner_image'].");
}
#header-text-wrap {
    ".'background-color: rgba('.$page['tmpl']['hol_color'].','.$page['tmpl']['hol_trans'].');'."
}
#top-text {
    margin: 0 auto;
    padding: 40px 0 !important;
    max-width: 80%;
}
#top-text h2, #top-text h3, #top-text h4 {
    text-align: left;
    margin-bottom: 20px;
}
#video-row {
    margin: 0 auto;
    padding: 0 0 40px !important;
    max-width: 80%;
    position: relative;
}
#cvg-page-container #middle-text p {
    text-align: center;
}
#middle-text {
    margin: 0 auto;
    padding: 0 0 40px !important;
    max-width: 80%;
}
#action-text {
    margin: 0 auto;
    padding: 0 0 80px !important;
    max-width: 80%;
}
a.cvg-button {
    color: rgb(".$page['tmpl']['btntxt_color'].");
    background-color: rgb(".$page['tmpl']['btnbg_color'].");
}
button.cvg-button, .form-type-btn.cvg-button {
    color: rgb(".$page['tmpl']['btntxt_color'].");
    background-color: rgb(".$page['tmpl']['btnbg_color'].");
}
#footer-text {
    padding: 20px 20%;
    border-top: 1px solid rgb(".$page['tmpl']['hl_color'].");
    color: rgb(".$page['tmpl']['ftxt_color'].");
    background: rgb(".$page['tmpl']['fbg_color'].");
}
#footer-text p {
    margin: 0; 
}

#header-text {
    height: 80vh;
}
#header-text-wrap {
    padding-top: 38vh;
    height: inherit;
}
@media (max-width: 768px ) {
    #logo { 
        max-height: 90px;
        padding: 8px 15px;
    }
    #header-text {
        font-size: 1.2em !important;
        height: 40vh;
    }
    #header-text-wrap {
        padding-top: 16vh;
    }
    h1 {
        font-size: 3.5em !important;
    }
    a.cvg-button {
        font-size: 1em !important;
    }
}
@media (max-width: 500px ) {
    h1 {
        font-size: 2.5em !important;
        padding-bottom: 0;
    }
    p {
        font-size: 1.25em !important;
    }
    #top-text, #middle-text {
        padding: 10px 0 !important;
        max-width: 95%;
    }
    #video-row {
        padding-bottom: 10px !important;
        max-width: 95%;
    }
    #action-text {
        padding-bottom: 50px !important;
        max-width: 95%;
    }
    #footer-text p {
        font-size: 1em !important;
    }
}
@media (max-width: 350px ) {
    h1 {
        font-size: 2em !important;
    }
    p {
        font-size: 1em !important;
    }
    
    #footer-text p {
        font-size: .75em !important;
    }
}");
?>
</style>

<?php
if (!isset($_GET['preview_mode']))
{
    echo $page['opt']['_cvg_lp_connect_ga_body'];
}
?>

</body>
</html>