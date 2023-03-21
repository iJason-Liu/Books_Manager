<?php

/* columns_definitions/column_comment.twig */
class __TwigTemplate_9b75bb501c1576ec75dffdd1d78a9a28fce153d701286604feaf82f844e4cd70 extends Twig_Template
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
        echo "<input id=\"field_";
        echo twig_escape_filter($this->env, (isset($context["column_number"]) ? $context["column_number"] : null), "html", null, true);
        echo "_";
        echo twig_escape_filter($this->env, ((isset($context["ci"]) ? $context["ci"] : null) - (isset($context["ci_offset"]) ? $context["ci_offset"] : null)), "html", null, true);
        echo "\"
    type=\"text\"
    name=\"field_comments[";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["column_number"]) ? $context["column_number"] : null), "html", null, true);
        echo "]\"
    size=\"12\"
    maxlength=\"";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["max_length"]) ? $context["max_length"] : null), "html", null, true);
        echo "\"
    value=\"";
        // line 6
        echo (isset($context["value"]) ? $context["value"] : null);
        echo "\"
    class=\"textfield\" />
";
    }

    public function getTemplateName()
    {
        return "columns_definitions/column_comment.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 6,  32 => 5,  27 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "columns_definitions/column_comment.twig", "/Applications/phpstudy/WWW/Books_Manager/phpmyAdmin4.8.5/templates/columns_definitions/column_comment.twig");
    }
}
