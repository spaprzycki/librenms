<?php

$rrd_filename = $config['rrd_dir'].'/'.$device['hostname'].'/'.safename('fortigate_sessions.rrd');

require 'includes/graphs/common.inc.php';

$ds = 'sessions';

$colour_area = '9999cc';
$colour_line = '0000cc';

$colour_area_max = '9999cc';

$graph_max = 1;

$unit_text = 'Sessions';

require 'includes/graphs/generic_simplex.inc.php';
