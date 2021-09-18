<?php

return [
    'result' => [
        'OK' => 'OK',
        'NG' => 'NG',
        'success' => [
            'status' => 200,
            'message' => '',
        ],
        'serverError' => [
            'status' => 500,
            'message' => '登録に失敗しました。',
        ],
        'validationError' => [
            'status' => 422,
            'message' => '',
        ],
    ],
];
