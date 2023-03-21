<?php

/* columns_definitions/column_null.twig */
class __TwigTemplate_3fa8a5186f544610f0ad3ba2020eb276881cd147753dd4a849896f480a577364 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<input name=\"field_null[";
        echo twig_escape_filter($this->env, (isset($context["column_number"]) ? $context["column_number"] : null), "html", null, true);
        echo "]\"
    id=\"field_";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["column_number"]) ? $context["column_number"] : null), "html", null, true);
        echo "_";
        echo twig_escape_filter($this->env, ((isset($context["ci"]) ? $context["ci"] : null) - (isset($context["ci_offset"]) ? $context["ci_offset"] : null)), "html", null, true);
        echo "\"
    ";
        // line 3
        if ((( !twig_test_empty($this->getAttribute((isset($context["column_meta"]) ? $context["column_meta"] : null), "Null", [], "array")) && ($this->getAttribute((isset($context["column_meta"]) ? $context["column_meta"] : null), "Null", [], "array") != "NO")) && ($this->getAttribute((isset($context["column_meta"]) ? $context["column_meta"] : null), "Null", [], "array") != "NOT NULL"))) {
            // line 4
            echo "checked=\"checked\"";
        }
        // line 6
        echo "    type=\"checkbox\"
    value=\"NULL\"
    class=\"allow_null\" />
";
    }

    public function getTemplateName()
    {
        return "columns_definitions/column_null.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 6,  32 => 4,  30 => 3,  24 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "columns_definitions/column_null.twig", "/Applications/phpstudy/WWW/Books_Manager/phpmyAdmin4.8.5/templates/columns_definitions/column_null.twig");
    }
}
