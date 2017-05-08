# form

Modul yang menyediakan service `form`. Modul ini bertugas mem-validasi form dan
menggenerasi view form field.

Modul form membutuhkan konfigurasi pada level aplikasi atau konfigurasi modul dengan
nama `form` yang berisi informasi nama-nama form, daftar field, dan rules validation
masing-masing field.

Contoh di bawah adalah contoh sederhana konfigurasi form:

```php
<?php

return [
    'name' => 'Phun',
    ...
    'form' => [
        'user-login' => [
            'name'      => [
                'type'      => 'text',
                'label'     => 'Username',
                'nolabel'   => false,
                'desc'      => 'Your registered username',
                'rules'     => [
                    'required'  => true,
                    'length'    => [
                        'min'       => 5,
                        'max'       => 25
                    ],
                    'alnum-dash'=> true
                ]
            ],
            'password' => [
                'type'      => 'password',
                'label'     => 'Password',
                'rules'     => [
                    'required'  => true
                ]
            ],
            'account' => [
                'type'      => 'select',
                'label'     => 'Account Type',
                'options'   => [
                    '1'         => 'Personal',
                    '2'         => 'Group'
                ],
                'rules'     => [
                    'required'  => true
                ]
            ]
        ]
    ]
];
```

Text `user-login` adalah nama form yang akan digunakan di kontroler, sementara array
key di bawahnya adalah nama field dengan konfigurasinya.

Properti field yang dikenal sejauh ini adalah `type`, `label`, `nolabel`, `desc`,
`rules`, `options`, sementara jika ada konfigurasi tambahan, akan diteruskan ke
view pada saat render field html.

Penggunaan pada kontroler kurang lebih seperti di bawah:

```php
<?php

...
    public function loginAction(){
        $user = new stdClass();
        
        $this->form->setForm('user-login');
        $this->form->setObject($user);
        
        if(false !== ($form = $this->form->validate())){
            // error found, or not POST request
            // view template here
        }
        
        // process $form
    }
    
    public function reLoginAction(){
        
        $user = new stdClass();
        
        // alternative
        if(false !== ($form = $this->form->validate('user-login', $user))){
            // invalid login
        }
        
        // process $form
    }
...
```

Keterangan lebih lanjut dan cara penggunaan dan rules-rules yang dikenali oleh
form validation bisa dilihat di wiki.