<?php

/* visa-free.html */
class __TwigTemplate_d510cb5dc4d92d5baa9280863650bf781c9b8cec7774464d59b82a7a240a4c4f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("base.html");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Visa-free countries";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "<p>Select citizenship</p>
<form name='select' action=\"\" method=\"post\">
\t<select name=\"countries\" id=\"countries\">
\t\t";
        // line 9
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["countries"]) ? $context["countries"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 10
            echo "\t\t<option>";
            echo twig_escape_filter($this->env, $this->getAttribute($context["country"], "name", array()), "html", null, true);
            echo "</option>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        echo "\t</select>
\t<input type=\"button\" id=\"check\" name=\"check\" value=\"OK\"><br><br>
\t<img src=\"load.gif\" alt=\"loader\" id=\"loader\">
\t<script type=\"text/javascript\">
\t\t\$( \"#loader\" ).hide();
\t\t\$( \"#check\" ).click(function() {
\t\t\t\$( \"#loader\" ).show();
  \t\t\tvar a = \$(\"#countries option:selected\").text();
  \t\t\t\$( \"#citizens\" ).html(a);
\t\t\t\$.post(\"http://localhost/visaless-random_visa/index.php\", { 'selected' : a }, function(data,status){ 
\t\t\t\$( \"#table\" ).html(data);
\t\t\t\$( \"#loader\" ).hide();})
\t\t});
\t</script>
\t</form>
\t<p>Countries that do not require visas for citizens of </p><p id='citizens'></p><hr>
\t<table border=\"1\" style=\"solid\">
\t\t<tbody id='table'>
\t\t\t
\t\t</tbody>
\t</table>
</form>

";
    }

    public function getTemplateName()
    {
        return "visa-free.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 12,  55 => 10,  51 => 9,  46 => 6,  43 => 5,  37 => 3,  11 => 1,);
    }
}
