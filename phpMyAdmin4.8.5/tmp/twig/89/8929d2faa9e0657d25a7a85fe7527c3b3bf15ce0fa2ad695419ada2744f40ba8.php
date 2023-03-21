<?php

/* table/secondary_tabs.twig */
class __TwigTemplate_1a858c3337ff1574385f47f189dddbe60b834046b85a62f6be5739344b1ef225 extends Twig_Template
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
        if (($this->getAttribute((isset($context["cfg_relation"]) ? $context["cfg_relation"] : null), "relwork", [], "array") || (isset($context["is_foreign_key_supported"]) ? $context["is_foreign_key_supported"] : null))) {
            // line 2
            echo "    <ul id=\"topmenu2\">
        ";
            // line 3
            echo PhpMyAdmin\Util::getHtmlTab(["icon" => "b_props", "link" => "tbl_structure.php", "text" => _gettext("Table structure"), "id" => "table_strucuture_id"],             // line 8
(isset($context["url_params"]) ? $context["url_params"] : null));
            echo "
        ";
            // line 9
            echo PhpMyAdmin\Util::getHtmlTab(["icon" => "b_relations", "link" => "tbl_relation.php", "text" => _gettext("Relation view"), "id" => "table_relation_id"],             // line 14
(isset($context["url_params"]) ? $context["url_params"] : null));
            echo "
    </ul>
    <div class=\"clearfloat\"></div>
";
        }
    }

    public function getTemplateName()
    {
        return "table/secondary_tabs.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 14,  29 => 9,  25 => 8,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "table/secondary_tabs.twig", "/Applications/phpstudy/WWW/Books_Manager/phpmyAdmin4.8.5/templates/table/secondary_tabs.twig");
    }
}
