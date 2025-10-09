{include file="header.tpl"}
<h1>Bonjour {$name|substr:0:2}... !!</h1>

{if $name == 'damien'}
    Est Admin
{else}

{/if}

{foreach key=i item=student from=$students}
    {include file="components/card_student.tpl" number=$i name=$student.nom_it}
{foreachelse}
    Aucun student
{/foreach}

{include file="footer.tpl"}
