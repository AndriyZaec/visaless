<?php

/* base.html */
class __TwigTemplate_6603b5229668e63542770183438cb49e75ce3e6cab762486c11afbda1f4c854d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"ru\">
<head>
    <title>";
        // line 4
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\"/>
  \t<script src=\"https://code.jquery.com/jquery-1.10.2.js\"></script>
</head>
<body>

<div id=\"content\">
    ";
        // line 11
        $this->displayBlock('content', $context, $blocks);
        // line 13
        echo "</div>

</body>
</html>";
    }

    // line 4
    public function block_title($context, array $blocks = array())
    {
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "    ";
    }

    public function getTemplateName()
    {
        return "base.html";
    }

    public function getDebugInfo()
    {
        return array (  53 => 12,  50 => 11,  45 => 4,  38 => 13,  36 => 11,  26 => 4,  21 => 1,);
    }
}
