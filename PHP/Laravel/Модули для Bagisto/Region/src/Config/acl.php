<?php

return [
    [
        'key'        => 'region',
        'name'       => 'region::app.default.title',
        'route'      => 'admin.region.index',
        'sort'       => 3,
        'icon-class' => 'dashboard-icon',
    ],
    [
        'key'       => 'region.main',
        'name'       => 'region::app.section.main.title',
        'route'      => 'admin.region.index',
        'sort'       => 1,
        'icon-class' => 'dashboard-icon',
    ],
    [
        'key'       => 'region.main.index',
        'name'       => 'region::app.default.show',
        'route'      => 'admin.region.index',
        'sort'       => 1,
        'icon-class' => 'dashboard-icon',
    ],
    [
        'key'       => 'region.main.edit',
        'name'       => 'region::app.default.edit',
        'route'      => 'admin.region.edit',
        'sort'       => 2,
        'icon-class' => 'dashboard-icon',
    ],
    [
        'key'       => 'region.main.create',
        'name'       => 'region::app.default.create',
        'route'      => 'admin.region.create',
        'sort'       => 3,
        'icon-class' => 'dashboard-icon',
    ],
    [
        'key'       => 'region.props',
        'name'       => 'region::app.section.props.title',
        'route'      => 'admin.region.props.index',
        'sort'       => 2,
        'icon-class' => 'dashboard-icon',
    ]
];

?>