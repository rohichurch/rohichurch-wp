<?php
/**
 * Template 3 
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
    font-family: Raleway, 'Roboto Condensed', Arial, sans-serif;
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
    background-color: #fff !important;
    color: #000 !important;
}
#cvg_invitation * {
    color: #000;
}
#cvg_invitation #cvg_invitation_err {
    color: #ba3c3c !important;
}

h1 {
    color: rgb(".$page['tmpl']['hd_txt_color'].");
    margin: 0px;
    font-size: 4em !important;
    font-family: Montserrat, 'Roboto Condensed', Arial, sans-serif;;
}
a {
    color: rgb(".$page['tmpl']['link_color'].");
    text-decoration: none;
}
a:hover {
    color: rgb(".$page['tmpl']['link_color'].");
    text-decoration: underline;
}
.container-fluid {
    padding: 0;
    position: relative;
    background: -webkit-radial-gradient(top right, rgba(".$page['tmpl']['bg_tr_color'].",".$page['tmpl']['bg_tr_trans'].") 20%, rgba(".$page['tmpl']['bg_tr_color'].",0) 60%); 
    background: -o-radial-gradient(top right, rgba(".$page['tmpl']['bg_tr_color'].",".$page['tmpl']['bg_tr_trans'].") 20%, rgba(".$page['tmpl']['bg_tr_color'].",0) 60%); 
    background: -moz-radial-gradient(top right, rgba(".$page['tmpl']['bg_tr_color'].",".$page['tmpl']['bg_tr_trans'].") 20%, rgba(".$page['tmpl']['bg_tr_color'].",0) 60%);
    background: radial-gradient(at top right, rgba(".$page['tmpl']['bg_tr_color'].",".$page['tmpl']['bg_tr_trans'].") 20%, rgba(".$page['tmpl']['bg_tr_color'].",0) 60%);
    overflow: hidden;
}
.container-fluid:before {
    content: ' ';
    display: block;
    position: absolute;
    bottom: 0;
    height: 100%;
    width: 90%;
    background: -webkit-radial-gradient(bottom left, rgba(".$page['tmpl']['bg_bl_color'].",".$page['tmpl']['bg_bl_trans'].") 20%, rgba(".$page['tmpl']['bg_bl_color'].",0) 60%);
    background: -o-radial-gradient(bottom left, rgba(".$page['tmpl']['bg_bl_color'].",".$page['tmpl']['bg_bl_trans'].") 20%, rgba(".$page['tmpl']['bg_bl_color'].",0) 60%);
    background: -moz-radial-gradient(bottom left, rgba(".$page['tmpl']['bg_bl_color'].",".$page['tmpl']['bg_bl_trans'].") 20%, rgba(".$page['tmpl']['bg_bl_color'].",0) 60%);
    background: radial-gradient(at bottom left, rgba(".$page['tmpl']['bg_bl_color'].",".$page['tmpl']['bg_bl_trans'].") 20%, rgba(".$page['tmpl']['bg_bl_color'].",0) 60%);
    z-index: -1;
}
.container-fluid:after {
    content: ' ';
    display: block;
    position: absolute;
    bottom: 0;
    right: 0;
    height: 80%;
    width: 80%;
    background: -webkit-radial-gradient(bottom right, rgba(".$page['tmpl']['bg_br_color'].",".$page['tmpl']['bg_br_trans'].") 20%, rgba(".$page['tmpl']['bg_br_color'].",0) 60%); 
    background: -o-radial-gradient(bottom right, rgba(".$page['tmpl']['bg_br_color'].",".$page['tmpl']['bg_br_trans'].") 20%, rgba(".$page['tmpl']['bg_br_color'].",0) 60%); 
    background: -moz-radial-gradient(bottom right, rgba(".$page['tmpl']['bg_br_color'].",".$page['tmpl']['bg_br_trans'].") 20%, rgba(".$page['tmpl']['bg_br_color'].",0) 60%); 
    background: radial-gradient(at bottom right, rgba(".$page['tmpl']['bg_br_color'].",".$page['tmpl']['bg_br_trans'].") 20%, rgba(".$page['tmpl']['bg_br_color'].",0) 60%); 
    z-index: -1;
}
#cvg-page-container #main-container p {
    line-height: 1.25em;
}
#main-container {
    padding: 0px !important;
}
#main-container .row {
    margin-right: 0;
    margin-left: 0;
}

#header-text-wrap {
    background-color: rgba(".$page['tmpl']['hd_ol_color'].",".$page['tmpl']['hd_ol_trans'].");
    -ms-transform: skewY(-2deg);
    -moz-transform: skewY(-2deg);
    -webkit-transform: skewY(-2deg);
    transform: skewY(-2deg);
    margin-top: -3vh;
    border: 1px solid rgba(".$page['tmpl']['hd_br_color'].",".$page['tmpl']['hd_br_trans'].");
    border-width: 0 0 1px 0;
}
#header-text-wrap h1 {
    -ms-transform: skewY(2deg);
    -moz-transform: skewY(2deg);
    -webkit-transform: skewY(2deg);
    transform: skewY(2deg);
    max-width: 800px;
    text-align: center;
    margin: 0 auto;
}


#top-text {
    margin: 0 auto;
    padding: 10px 0 40px !important;
    width: 90%;
}
#top-text h2, #top-text h3, #top-text h4 {
    text-align: left;
    margin-bottom: 20px;
}
#cvg-page-container #top-text, 
#cvg-page-container #video-row, 
#cvg-page-container #middle-text, 
#cvg-page-container #action-text {
    max-width: 800px;
}
#video-row {
    margin: 0 auto;
    padding: 0 0 40px !important;
    width: 90%;
    position: relative;
}
#cvg-page-container #middle-text p {
    text-align: center;
}
#middle-text {
    margin: 0 auto;
    padding: 0 0 40px !important;
    width: 90%;
}
#action-text {
    margin: 0 auto;
    padding: 0 0 80px !important;
    width: 90%;
}
a.cvg-button {
    color: rgb(".$page['tmpl']['btn_txt_color'].");
    background-color: rgb(".$page['tmpl']['btn_bg_color'].");
}
button.cvg-button, .form-type-btn.cvg-button {
    color: rgb(".$page['tmpl']['btn_txt_color'].") !important;
    background-color: rgb(".$page['tmpl']['btn_bg_color'].");
}
#cvg-page-container #footer-text.row {
    padding: 60px 0 40px 0;
}
#footer-text {
    background-color: rgba(".$page['tmpl']['ft_ol_color'].",".$page['tmpl']['ft_ol_trans'].");
    border: 1px solid rgba(".$page['tmpl']['ft_br_color'].",".$page['tmpl']['ft_br_trans'].");
    border-width: 1px 0 0 0;
    -ms-transform: skewY(2deg);
    -moz-transform: skewY(2deg);
    -webkit-transform: skewY(2deg);
    transform: skewY(2deg);
    margin-bottom: -2%;
}
#footer-text p {
    color: rgb(".$page['tmpl']['ft_txt_color'].");
    -ms-transform: skewY(-2deg);
    -moz-transform: skewY(-2deg);
    -webkit-transform: skewY(-2deg);
    transform: skewY(-2deg);
    min-height: 50px;
}

#header-text-wrap {
    padding: 8vh 0 6vh;
    height: inherit;
}

@media (max-width: 1024px ) {
    #header-text-wrap {
        padding: 6vh 0 4vh;
    }
}

@media (max-width: 768px ) {
    #header-text {
        font-size: 1.2em !important;
    }
    h1 {
        font-size: 3.5em !important;
    }
    a.cvg-button {
        font-size: 1em !important;
    }
    #cvg-page-container #footer-text.row {
        padding: 40px 0 0 0;
    }
}
@media (max-width: 500px ) {
    h1 {
        font-size: 2.5em !important;
    }
    p {
        font-size: 1.25em !important;
    }
    #cvg-page-container #header-text.row {
        padding: 0 0 20px 0;
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