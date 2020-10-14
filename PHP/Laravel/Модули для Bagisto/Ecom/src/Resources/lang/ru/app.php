<?php

return [
    "default" => [
        "ecom" => "Ecom",
        "delete" => "Удалить",
        "edit" => "Редактировать"
    ],
    "section" => [
        "import" => [
            "title" => "Список импортов",
            "menu-title" => "Импорты",
            "run" => "Запустить",

            "fields" => [
                "id" => "ID",
                "name" => "Название",
                "code" => "Символьный код",
                "type" => "Тип импорта",
                "time" => "Время начала",
                "last_import" => "Последний запуск",
                "last_import_status" => "Статус",
                "interval" => "Периодичность",
                "enable" => "Активность"
            ],
        ],

        "type" => [
            "title" => "Список типов импортов",
            "menu-title" => "Типы импортов",

            "fields" => [
                "id" => "ID",
                "name" => "Название",
                "code" => "Символьный код",
                "enable" => "Активность"
            ],
        ],

        "interval" => [
            "title" => "Список интервалов",
            "menu-title" => "Интервалы",

            "fields" => [
                "id" => "ID",
                "name" => "Название",
                "interval" => "Периодичность, c",
            ],
        ],

    ]
];
