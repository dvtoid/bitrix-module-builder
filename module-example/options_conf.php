<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(dirname(__FILE__) . '/options.php');

$options = [
    [
        'DIV' => 'settings-tab',
        'TAB' => Loc::getMessage('#MESS#_TAB'),
        'TITLE' => Loc::getMessage('#MESS#_TITLE'),
        'ICON' => '',
        'GROUPS' => [
            'GROUP_1' => [
                'TITLE' => Loc::getMessage('#MESS#_GROUP_1'),
                'OPTIONS' => [
                    'ACTIVE' => [
                        'SORT' => 100,
                        'TYPE' => 'CHECKBOX',
                        'FIELDS' => [
                            'TITLE' => Loc::getMessage('#MESS#_ACTIVE'),
                            'DEFAULT' => 'N',
                        ],
                    ],
                    'TEXT' => [
                        'SORT' => 200,
                        'TYPE' => 'STRING',
                        'FIELDS' => [
                            'TITLE' => Loc::getMessage('#MESS#_TEXT'),
                            'DEFAULT' => '',
                            'PLACEHOLDER' => Loc::getMessage('#MESS#_TEXT'),
                            'TAG' => Loc::getMessage('#MESS#_TEXT_TAG'),
                            'NOTES' => Loc::getMessage('#MESS#_TEXT_NOTE'),
                            'READONLY' => false,
                            'DISABLED' => false,
                            'AUTOCOMPLETE' => false,
                        ],
                    ],
                    'DROPDOWN' => [
                        'SORT' => 300,
                        'TYPE' => 'DROPDOWN',
                        'FIELDS' => [
                            'TITLE' => Loc::getMessage('#MESS#_DROPDOWN'),
                            'DEFAULT' => '2',
                            'OPTIONS' => [
                                [
                                    'TITLE' => 'One',
                                    'VALUE' => '1',
                                ],
                                [
                                    'TITLE' => 'Two',
                                    'VALUE' => '2',
                                ],
                                [
                                    'TITLE' => 'Three',
                                    'VALUE' => '3',
                                ],
                            ],
                        ],
                    ],
                    'MULTISELECT' => [
                        'SORT' => 400,
                        'TYPE' => 'MULTISELECT',
                        'FIELDS' => [
                            'TITLE' => Loc::getMessage('#MESS#_MULTISELECT'),
                            'DEFAULT' => serialize(['1', '3']),
                            'OPTIONS' => [
                                [
                                    'TITLE' => 'One',
                                    'VALUE' => '1',
                                ],
                                [
                                    'TITLE' => 'Two',
                                    'VALUE' => '2',
                                ],
                                [
                                    'TITLE' => 'Three',
                                    'VALUE' => '3',
                                ],
                            ],
                        ],
                    ],
                ]
            ],
            'GROUP_2' => [
                'TITLE' => Loc::getMessage('#MESS#_GROUP_2'),
                'OPTIONS' => [
                    'ALERT' => [
                        'TYPE' => 'ALERT',
                        'FIELDS' => [
                            'TITLE' => Loc::getMessage('#MESS#_ALERT'),
                        ],
                        'PARAMS' => [
                            'DISPLAY' => true,
                            'HEIGHT' => false,
                            'COLOR' => 'warning',
                            'ICON' => 'warning',
                        ]
                    ],
                ]
            ]
        ],
    ]
];

if (Loader::includeModule('fileman')) {
    $options[0]['GROUPS']['GROUP_2']['OPTIONS']['HTML'] = [
        'TYPE' => 'HTMLEDITOR',
        'FIELDS' => [
            'TITLE' => Loc::getMessage('#MESS#_HTML'),
        ],
        'PARAMS' => [
            'WIDTH' => '100%',
            'HEIGHT' => '500',
            'PHP' => false,
            'TASKBAR' => false,
        ]
    ];
}

if (Loader::includeModule('catalog')) {
    $options[0]['GROUPS']['GROUP_2']['OPTIONS']['CONDITIONS'] = [
        'TYPE' => 'CONDITIONS',
        'FIELDS' => [
            'TITLE' => Loc::getMessage('#MESS#_CONDITIONS'),
        ]
    ];
}

return $options;