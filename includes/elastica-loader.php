<?php
// Loading Elastica classes as needed
function __autoload_elastica ($class) {
    $path = str_replace('\\', '/', $class);
    if (file_exists('/opt/librenms/lib/Elastica/lib/' . $path . '.php')) {
        require_once('/opt/librenms/lib/Elastica/lib/' . $path . '.php');
    }
}
spl_autoload_register('__autoload_elastica');

?>
