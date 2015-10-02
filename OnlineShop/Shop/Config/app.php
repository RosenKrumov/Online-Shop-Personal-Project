<?php
$cnf['default_controller'] = 'Index';
$cnf['default_method'] = 'index';

$cnf['namespaces']['Controllers'] = '../Controllers';
$cnf['namespaces']['Areas\Admin\Controllers'] = '../Areas/Admin/Controllers';
$cnf['namespaces']['Areas\Admin\Models'] = '../Areas/Admin/Models';
$cnf['namespaces']['Areas\Admin\Models\BindingModels'] = '../Areas/Admin/Models/BindingModels';
$cnf['namespaces']['Models'] = '../Models';
$cnf['namespaces']['Models\BindingModels'] = '../Models/BindingModels';


$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'native';
$cnf['session']['name'] = '__sess';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;

return $cnf;