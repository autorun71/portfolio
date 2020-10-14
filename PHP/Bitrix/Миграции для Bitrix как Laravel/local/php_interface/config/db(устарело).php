<?php
return [
    'tables' => [
        [
            'name' => 'debug_bar',
            'fields' => [
                'ID' => [
                    'type' => [
                        'name' => 'int',
                        'length' => 100
                    ],
                    'not_null' => true,
                    'primary' => true,
                    'increment' => [
                        'status' => true,
                        'value' => 1
                    ],
                    'default' => false
                ],
                'TEXT' => [
                    'type' => [
                        'name' => 'text',
                        'length' => false
                    ],
                    'not_null' => true,
                    'default' => false
                ],
                'USER' => [
                    'type' => [
                        'name' => 'varchar',
                        'length' => 100
                    ],
                    'not_null' => true,
                    'default' => ''
                ],
                'TYPE' => [
                    'type' => [
                        'name' => 'varchar',
                        'length' => 100
                    ],
                    'not_null' => true,
                    'default' => ''
                ],
                'OBJECT' => [
                    'type' => [
                        'name' => 'text',
                        'length' => false
                    ],
                    'not_null' => true,
                    'default' => false
                ],
                'START_TIME' => [
                    'type' => [
                        'name' => 'int',
                        'length' => 100
                    ],
                    'not_null' => true,
                    'default' => 0
                ],
                'TIMESTAMP' => [
                    'type' => [
                        'name' => 'int',
                        'length' => 100
                    ],
                    'not_null' => true,
                    'default' => 0
                ]
            ] // fields
        ],

        [
            'name' => 'debug_bar_objects',
            'fields' => [
                'ID' => [
                    'type' => [
                        'name' => 'int',
                        'length' => 11
                    ],
                    'not_null' => true,
                    'primary' => true,
                    'increment' => [
                        'status' => true,
                        'value' => 1
                    ],
                    'default' => false
                ],
                'OBJECT' => [
                    'type' => [
                        'name' => 'text',
                        'length' => false
                    ],
                    'not_null' => true,
                    'default' => false
                ],
                'PARAMS' => [
                    'type' => [
                        'name' => 'varchar',
                        'length' => 100
                    ],
                    'not_null' => true,
                    'default' => ''
                ],
                'DEBUG_BAR_ID' => [
                    'type' => [
                        'name' => 'int',
                        'length' => 100
                    ],
                    'not_null' => true,
                    'default' => 0,
                    'foreign' => [
                        'table' => 'debug_bar',
                        'table_field' => 'id_user'
                    ]
                ]

            ] // fields
        ]
    ],



];