<?php
/**
 * Template 4 
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
$(document).ready(function()
{
    // adds video wrap
    $('#video-row').wrap('<div id="video-wrap" class="row"></div>');
});
</script>

<style>
<?php 
    echo cvg_lp_connect_public::css_str_replace("
* {
    font-family: Raleway, 'Roboto Condensed', sans-serif;
    color: rgb(".$page['tmpl']['bd_txt_color'].");
    text-align: center;
}
body {  
    background-color: rgb(".$page['tmpl']['bg_color'].");
}
.in-iframe #cvg-page-container.preview {
    margin-top: 0 !important;
}
#cvg_invitation {
    background-color: rgb(".$page['tmpl']['bg_color'].") !important;
}
#cvg_invitation #cvg_invitation_err {
    color: rgb(".$page['tmpl']['link_color'].") !important;
}
h1 {
    line-height: 1;
    color: rgb(".$page['tmpl']['hd_txt_color'].");
    margin: 0px;
    font-size: 4em !important;
    padding-top: 40px;
    padding-bottom: 10px;
    font-family: Montserrat, 'Roboto Condensed', cursive;
}
a {
    color: rgb(".$page['tmpl']['link_color'].");
    text-decoration: none;
}
a:hover {
    color: rgb(".$page['tmpl']['link_color'].");
    text-decoration: underline;
}
#cvg-page-container #main-container p {
    line-height: 1.25em;
}
#main-container {
    padding: 0px !important;
}
#cvg-page-container #header-text.row {
    padding: 0;
    margin: 0 auto;
}
#cvg-page-container #header-text,
#cvg-page-container #top-text, 
#cvg-page-container #video-row, 
#cvg-page-container #middle-text, 
#cvg-page-container #action-text {
    max-width: 800px;
}
#cvg-page-container #top-text.row {
    margin: 0 auto;
    padding-bottom: 0px;
}
#top-text h2, #top-text h3, #top-text h4 {
    text-align: left;
    margin-bottom: 20px;
}
#cvg-page-container #video-wrap.row {
    position: relative;
    padding: 0;
    margin-top: 100px;
    margin-bottom: 100px;
}
#video-wrap:before {
    background-color: rgba(".$page['tmpl']['bg_bar_color'].", ".$page['tmpl']['bg_bar_trans'].");
    position: absolute;
    top: 10%;
    left: 0;
    right: 0;
    bottom: 10%;
    display: block;
    -ms-transform: skewY(1deg);
    -moz-transform: skewY(1deg);
    -webkit-transform: skewY(1deg);
    transform: skewY(1deg);
    z-index: -1;
}
#video-wrap:after {
    background-color: rgba(".$page['tmpl']['bar_skew_color'].", ".$page['tmpl']['bar_skew_trans'].");
    position: absolute;
    top: 10%;
    left: 0;
    right: 0;
    bottom: 10%;
    display: block;
    -ms-transform: skewY(-1deg);
    -moz-transform: skewY(-1deg);
    -webkit-transform: skewY(-1deg);
    transform: skewY(-1deg);
    z-index: -1;
}
#cvg-page-container #video-row.row {
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    display: block;
    box-shadow: 0px 0px 100px rgba(0,0,0,.4);
}
#middle-text {
    margin: 0 auto;
    padding: 0 0 40px !important;
}
#cvg-page-container #middle-text p {
    text-align: center;
}
#action-text {
    margin: 0 auto;
    padding: 0 0 80px !important;
}
a.cvg-button {
    color: rgb(".$page['tmpl']['btn_txt_color'].");
    background-color: rgb(".$page['tmpl']['btn_bg_color'].");
}
button.cvg-button, .form-type-btn.cvg-button {
    color: rgb(".$page['tmpl']['btn_txt_color'].");
    background-color: rgb(".$page['tmpl']['btn_bg_color'].");
}
#cvg-page-container #footer-text.row {
    padding: 40px 20%;
    background: rgb(".$page['tmpl']['ft_bg_color'].");
}
#footer-text p {
    color: rgb(".$page['tmpl']['ft_txt_color'].");
    margin: 0; 
}

@media (max-width: 768px ) {
    #cvg-page-container #header-text,
    #cvg-page-container #top-text, 
    #cvg-page-container #video-row, 
    #cvg-page-container #middle-text, 
    #cvg-page-container #action-text {
        max-width: 85%;
    }
    #header-text {
        font-size: 1.2em !important;
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
    }
    p {
        font-size: 1.25em !important;
    }
    #cvg-page-container #video-wrap.row {
        margin-top: 50px;
        margin-bottom: 50px;
    }
    #cvg-page-container #video-row.row {
        padding: 10px;
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
}
");
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