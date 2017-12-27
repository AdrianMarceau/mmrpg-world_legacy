<?php

// Define wrapper class for legacy page object
class LegacyPage {

    // Define private root variables
    private $root_dir;
    private $root_url;
    private $cache_date;
    private $ga_accountid;

    // Define HTML page variables
    public $seo_title;
    public $seo_keywords;
    public $seo_description;
    public $content_title;
    public $content_description;
    public $content_markup;
    public $styles_markup;
    public $scripts_markup;

    // Define the construct for this page legacy page object
    public function __construct($config){

        // Collect the config arguments in provided format
        if (empty($config) || !is_array($config)){
            $config = func_get_args();
            if (empty($config) || !is_array($config)){
                $config = array();
            }
        }

        // Collect any of the root config variables
        $this->root_dir = isset($config['root_dir']) ? $config['root_dir'] : (isset($config[0]) ? $config[0] : '/var/www/html/');
        $this->root_url = isset($config['root_url']) ? $config['root_url'] : (isset($config[1]) ? $config[1] : 'http://www.domain.com/');
        $this->cache_date = isset($config['cache_date']) ? $config['cache_date'] : (isset($config[2]) ? $config[2] : '20XX-YY-ZZ');
        $this->ga_accountid = isset($config['ga_accountid']) ? $config['ga_accountid'] : (isset($config[2]) ? $config[2] : 'UA-00000000-0');

        // Predefine default page variables
        $this->seo_title = 'LegacyWebsite.NET';
        $this->seo_keywords = '';
        $this->seo_description = '';
        $this->content_title = 'LegacyWebsite.NET';
        $this->content_description = '';
        $this->content_markup = '';
        $this->styles_markup = '';
        $this->scripts_markup = '';

    }


    // -- COMMON CONTROLLERS -- //

    // Define a function for getting or setting the title variables
    public function setTitle($title){ $this->setSeoTitle($title)->setContentTitle($title); return $this; }
    public function addTitle($title){ $this->addSeoTitle($title)->addContentTitle($title); return $this; }


    // -- SEO CONTROLLERS -- //

    // Define a function for getting or setting the seo title variable
    public function getSeoTitle(){ return $this->seo_title; }
    public function setSeoTitle($title){ $this->seo_title = trim($title, '| '); return $this; }
    public function addSeoTitle($title){ $this->seo_title = trim($title, '| ').' | '.$this->seo_title; return $this; }

    // Define a function for getting or setting the seo title variable
    public function getSeoKeywords(){ return $this->seo_keywords; }
    public function setSeoKeywords($keywords){ $this->seo_keywords = trim($keywords); return $this; }
    public function addSeoKeywords($keywords){ $this->seo_keywords = $this->seo_keywords.' '.trim($keywords); return $this; }

    // Define a function for getting or setting the seo description variable
    public function getSeoDescription(){ return $this->seo_description; }
    public function setSeoDescription($description){ $this->seo_description = trim($description); return $this; }
    public function addSeoDescription($description){ $this->seo_description = $this->seo_description.' '.trim($description); return $this; }


    // -- CONTENT CONTROLLERS -- //

    // Define a function for getting or setting the content title variable
    public function getContentTitle(){ return $this->content_title; }
    public function setContentTitle($title){ $this->content_title = trim($title, '| '); return $this; }
    public function addContentTitle($title){ $this->content_title = $this->content_title.' | '.trim($title, '| '); return $this; }

    // Define a function for getting or setting the content description variable
    public function getContentDescription(){ return $this->content_description; }
    public function setContentDescription($description){ $this->content_description = trim($description); return $this; }
    public function addContentDescription($description){ $this->content_description = $this->content_description.' '.trim($description); return $this; }

    // Define a function for getting or setting the content markup variable
    public function getContentMarkup(){ return $this->content_markup; }
    public function setContentMarkup($markup){ $this->content_markup = trim($markup); return $this; }
    public function addContentMarkup($markup){ $this->content_markup = $this->content_markup.PHP_EOL.trim($markup); return $this; }


    // -- SCRIPT/STYLE CONTROLLERS -- //

    // Define a function for getting or setting the style markup variable
    public function getStyleMarkup(){ return $this->styles_markup; }
    public function setStyleMarkup($markup){ $this->styles_markup = trim($markup); return $this; }
    public function addStyleMarkup($markup){ $this->styles_markup = $this->styles_markup.PHP_EOL.trim($markup); return $this; }

    // Define a function for getting or setting the script markup variable
    public function getScriptMarkup(){ return $this->scripts_markup; }
    public function setScriptMarkup($markup){ $this->scripts_markup = trim($markup); return $this; }
    public function addScriptMarkup($markup){ $this->scripts_markup = $this->scripts_markup.PHP_EOL.trim($markup); return $this; }


    // -- PAGE CONTENT GENERATORS -- //

    // Define a function for adding new gallery markup specifically
    public function addContentGallery($image_folders, $image_base_dir = '', $image_base_url = ''){

        // Include the gallery markup generator and collect output
        ob_start();
        include(LEGACY_MMRPG_ROOT_DIR.'markup/image-gallery.php');
        $html_markup = ob_get_clean();

        // Add generated gallery markup to the page
        $this->addContentMarkup($html_markup);

    }


    // -- OUTPUT FUNCTIONS -- //

    // Define a public function for printing out the HTML page
    public function printHtmlPage(){

        // Change the content headers to that of HTML
        header('Content-type: text/html; charset=utf8');

        // Include the HTML wrapper and collect output
        ob_start();
        require_once(LEGACY_MMRPG_ROOT_DIR.'markup/html-wrapper.php');
        $html_markup = ob_get_clean();

        // Print out the collected markup and exit
        echo($html_markup);
        exit();

    }

}

?>