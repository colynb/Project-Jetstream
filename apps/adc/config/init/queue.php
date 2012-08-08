<?php

use jetstream\core\System;

/**
 * JS Libraries
 */
System::queue('js', array('src' => '/js/jquery/jquery.min.js'));
System::queue('js', array('src' => '/js/base/alerts.js'));
System::queue('js', array('src' => '/js/base/buttons.js'));
System::queue('js', array('src' => '/js/base/dropdown.js'));
System::queue('js', array('src' => '/js/base/modal.js'));
System::queue('js', array('src' => '/js/base/tabs.js'));

/**
 * Error Handling Styles and JS
 */
System::queue('css', array('src' => '/css/shutdown-error.css'));
System::queue('css', array('src' => '/js/syntax_highlighter/styles/shCore.css'));
System::queue('css', array('src' => '/js/syntax_highlighter/styles/shThemeDefault.css'));

System::queue('js', array('src' => '/js/shutdown-error.js'));
System::queue('js', array('src' => '/js/syntax_highlighter/scripts/shCore.js'));
System::queue('js', array('src' => '/js/syntax_highlighter/scripts/shBrushPhp.js'));

/**
 * Styles
 */
System::queue('css', array('src' => '/css/base/reset.css'));
System::queue('css', array('src' => '/css/base/grid.css'));
System::queue('css', array('src' => '/css/base/styles.css'));
System::queue('css', array('src' => '/css/base/alerts.css'));
System::queue('css', array('src' => '/css/base/tooltip.css'));
System::queue('css', array('src' => '/css/base/forms.css'));
System::queue('css', array('src' => '/css/base/buttons.css'));
System::queue('css', array('src' => '/css/base/sections.css'));
System::queue('css', array('src' => '/css/base/tables.css'));
System::queue('css', array('src' => '/css/base/tabs.css'));
System::queue('css', array('src' => '/css/base/text.css'));

