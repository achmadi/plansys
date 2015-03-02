<?php 

 return array (
    array (
        'label' => 'Builder',
        'items' => array (
            array (
                'label' => 'Form Builder',
                'icon' => 'fa-gavel',
                'url' => '/dev/forms/index',
            ),
            array (
                'label' => '---',
                'icon' => '',
                'url' => '#',
            ),
            array (
                'label' => 'Menu Editor',
                'icon' => 'fa-sitemap',
                'url' => '/dev/menus/index',
            ),
            array (
                'label' => '---',
                'icon' => '',
                'url' => '#',
            ),
            array (
                'label' => 'Module Generator',
                'icon' => 'fa-empire',
                'url' => '#',
            ),
            array (
                'label' => 'Controller Generator',
                'icon' => 'fa-cubes',
                'url' => '/dev/controllerGenerator/index',
            ),
            array (
                'label' => 'Model Generator',
                'icon' => 'fa-cube',
                'url' => '/dev/modelGenerator/index',
            ),
            array (
                'label' => '---',
                'icon' => '',
                'url' => '#',
            ),
            array (
                'label' => 'Form Generator',
                'icon' => 'fa-trello',
                'url' => '/dev/formGenerator/index',
            ),
        ),
        'state' => 'collapsed',
        'icon' => 'fa-gavel',
    ),
    array (
        'label' => 'Users',
        'icon' => 'fa-user',
        'url' => '#',
        'items' => array (
            array (
                'label' => 'User List',
                'icon' => 'fa-user',
                'url' => '/dev/user/index',
            ),
            array (
                'label' => 'Role Manager',
                'icon' => 'fa-graduation-cap',
                'url' => '/dev/user/roles',
            ),
        ),
        'state' => 'collapsed',
    ),
    array (
        'label' => 'Database',
        'icon' => 'fa-database',
        'url' => '/dev/default/adminer',
    ),
    array (
        'label' => 'Settings',
        'icon' => 'fa-sliders',
        'url' => '/dev/settings/index',
    ),
    array (
        'label' => 'Repository',
        'icon' => 'fa-folder-open',
        'url' => '/repo/index',
    ),
);