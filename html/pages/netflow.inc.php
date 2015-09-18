<?php

$pagetitle[] = 'Netflow';
$queries = array('top-talkers', 'protocols');
$link_array = array('page' => 'netflow');

if ($_GET['optb'] == 'graphs' || $_GET['optc'] == 'graphs') {
    $graphs = 'graphs';
}
else {
    $graphs = 'nographs';
}

$type_text['top-talkers']  = 'Top Talkers';
$type_text['protocols']  = 'Protocols';

print_optionbar_start();

echo "<span style='font-weight: bold;'>Netflow</span> &#187; ";

unset($sep);
foreach ($queries as $texttype) {
    $query = strtolower($texttype);
    echo($sep);
    if ($vars['query'] == $query) {
        echo("<span class='pagemenu-selected'>");
    }

    echo(generate_link($type_text[$query], $link_array, array('query'=> $query, 'view' => $vars['view'])));

    if ($vars['query'] == $query) {
        echo("</span>");
    }

    $sep = ' | ';
}

unset ($sep);

print_optionbar_end();

switch ($vars['query']) {
    case 'top-talkers':
        include 'pages/netflow/'.$vars['query'].'.inc.php';
    case 'protocols':
        include 'pages/netflow/'.$vars['query'].'.inc.php';
    break;
    default:
        echo report_this('Unknown protocol '.$vars['protocol']);
    break;
}
