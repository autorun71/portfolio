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
        'key'       => 'region.props',
        'name'       => 'region::app.section.props.title',
        'route'      => 'admin.region.props.index',
        'sort'       => 2,
        'icon-class' => 'dashboard-icon',
    ]
];