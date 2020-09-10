<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Users Language Lines
    |--------------------------------------------------------------------------
    */

    'notifications' => [

        'registered' => [

            'mail' => [
                'subject' => 'Confirmación de tu email',
                'greeting' => 'Hola, :name.',
                'intro_line_1' => 'Gracias por registrarte en Laravel Boilerplate. Ahora sólo falta que confirmes tu email.',
                'intro_line_2' => 'Haz clic en el siguiente botón.',
                'action' => 'Confirma tu correo',
                'salutation' => 'Un saludo<br>Laravel Boilerplate',
            ],
        ],

        'requested_verification' => [

            'mail' => [
                'subject' => 'Confirmación de tu email',
                'greeting' => 'Hola, :name.',
                'intro_line' => 'Haz clic en el siguiente botón para confirmar tu email.',
                'action' => 'Confirma tu correo',
                'salutation' => 'Un saludo<br>Laravel Boilerplate',
            ],
        ],

        'verified' => [

            'mail' => [
                'subject' => '¡Bienvenido a Laravel Boilerplate!',
                'greeting' => 'Hola, :name.',
                'intro_line_1' => '¡Te estábamos esperando!',
                'intro_line_2' => 'Ya formas parte de la familia Laravel Boilerplate. Nos encanta tenerte con nosotros.',
                'intro_line_3' => '¡Ahora sólo falta que lo disfrutes!',
                'action' => 'Accede a tu cuenta',
                'outro_line' => 'Consulta las [condiciones de uso](:url).',
                'salutation' => 'Un saludo<br>Laravel Boilerplate',
            ],
        ],

        'forgot_password' => [

            'mail' => [
                'subject' => 'Restablecer contraseña',
                'greeting' => 'Hola, :name.',
                'intro_line' => 'Hemos recibido tu solicitud de cambio de contraseña. Recuerda que la nueva contraseña debe tener un mínimo de 8 caracteres.',
                'action' => 'Cambiar contraseña',
                'outro_line_1' => 'Este link expira en :count minutos.',
                'outro_line_2' => 'Si no has solicitado el cambio de contraseña, por favor, ignora este email.',
                'salutation' => 'Un saludo<br>Laravel Boilerplate',
            ],
        ],
    ],

];
