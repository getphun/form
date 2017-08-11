<?php
/**
 * form config file
 * @package form
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'form',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/form',
    '__files' => [
        'modules/form' => [
            'install',
            'remove',
            'update'
        ]
    ],
    '__dependencies' => [
        'core',
        'db-mysql'
    ],
    '_services' => [
        'form' => 'Form\\Service\\Form'
    ],
    '_autoload' => [
        'classes' => [
            'Form\\Service\\Form'       => 'modules/form/service/Form.php',
            'Form\\Library\\Validator'  => 'modules/form/library/Validator.php',
            'Form\\Library\\Filter'     => 'modules/form/library/Filter.php'
        ],
        'files' => []
    ],
    
    'form_validation' => [
        'filter' => [
            'lowercase' => [
                'options'   => [],
                'handler'   => [
                    'class'     => 'Form\\Library\\Filter',
                    'action'    => 'lowercase'
                ]
            ],
            'uppercase' => [
                'options'   => [],
                'handler'   => [
                    'class'     => 'Form\\Library\\Filter',
                    'action'    => 'uppercase'
                ]
            ],
            'string' => [
                'options'   => [],
                'handler'   => [
                    'class'     => 'Form\\Library\\Filter',
                    'action'    => 'string'
                ]
            ],
            'number' => [
                'options'   => [],
                'handler'   => [
                    'class'     => 'Form\\Library\\Filter',
                    'action'    => 'number'
                ]
            ]
        ],
        
        'validator' => [
            'alnumdash' => [
                'message' => 'Field :field is accept only alphanumeric and dash character',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'alnumdash'
                ]
            ],
            
            'callback' => [
                'message' => 'Field :field is not acceptable',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'callback'
                ]
            ],
            
            'date' => [
                'message' => 'Field :field is not valid date',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'date'
                ]
            ],
            
            'email' => [
                'message' => 'Field :field is not valid email address',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'email'
                ]
            ],
            
            'length' => [
                'message' => 'Field :field length should be in acceptable range',
                'options' => [
                    'min'   => '~',
                    'max'   => '~'
                ],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'length'
                ]
            ],
            
            'numeric' => [
                'message' => 'Field :field must be numeric ( in acceptable range )',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'numeric'
                ]
            ],
            
            'regex' => [
                'message' => 'Field :field is not match pattern',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'regex'
                ]
            ],
            
            'required' => [
                'message' => 'Field :field is required',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'required'
                ]
            ],
            
            'unique' => [
                'message' => 'Field :field already used',
                'options' => [
                    'model'     => '',
                    'field'     => ''
                ],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'unique'
                ]
            ],
            
            'url' => [
                'message' => 'Field :field is not valid URL',
                'options' => [],
                'handler' => [
                    'class' => 'Form\\Library\\Validator',
                    'action'=> 'url'
                ]
            ]
        ]
    ]
];