<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute deve ser aceito.',
    'active_url'           => ':attribute não é um URL válido.',
    'after'                => ':attribute deve ser uma data após: date.',
    'after_or_equal'       => ':attribute deve ser uma data posterior ou igual a: date.',
    'alpha'                => ':attribute só pode conter letras.',
    'alpha_dash'           => ':attribute só pode conter letras, números e traços.',
    'alpha_num'            => ':attribute só pode conter letras e números.',
    'array'                => ':attribute deve ser uma matriz.',
    'before'               => ':attribute deve ser uma data anterior: date.',
    'before_or_equal'      => ':attribute deve ser uma data anterior ou igual a: date.',
    'between'              => [
        'numeric' => ':attribute deve estar entre: min e: max.',
        'file'    => ':attribute deve estar entre: min e: max kilobytes.',
        'string'  => ':attribute deve estar entre: min e: max characters.',
        'array'   => ':attribute deve ter entre: min e: max items.',
    ],
    'boolean'              => ':attribute campo deve ser verdadeiro ou falso.',
    'confirmed'            => ':attribute confirmação não corresponde.',
    'date'                 => ':attribute não é uma data válida.',
    'date_format'          => ':attribute não corresponde ao formato :format.',
    'different'            => ':attribute e :other devem ser diferentes.',
    'digits'               => ':attribute devem ser :digits digitos.',
    'digits_between'       => ':attribute deve estar entre :min e :max digitos.',
    'dimensions'           => ':attribute tem dimensões de imagem inválidas.',
    'distinct'             => ':attribute campo tem um valor duplicado.',
    'email'                => ':attribute deve ser um endereço de e-mail válido.',
    'exists'               => ':attribute selecionado é invalido.',
    'file'                 => ':attribute deve ser um arquivo.',
    'filled'               => ':attribute campo deve ter um valor.',
    'image'                => ':attribute deve ser uma imagem.',
    'in'                   => ':attribute selecionado é invalido.',
    'in_array'             => ':attribute campo não existe em :other.',
    'integer'              => ':attribute deve ser um número inteiro',
    'ip'                   => ':attribute must be a valid IP address.',
    'ipv4'                 => ':attribute must be a valid IPv4 address.',
    'ipv6'                 => ':attribute must be a valid IPv6 address.',
    'json'                 => ':attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute não pode ser maior do que :max.',
        'file'    => ':attribute não pode ser maior do que :max kilobytes.',
        'string'  => ':attribute não pode ser maior do que :max characters.',
        'array'   => ':attribute não pode ter mais do que :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute deve ser pelo menos :min.',
        'file'    => ':attribute deve ser pelo menos :min kilobytes.',
        'string'  => ':attribute deve ser pelo menos :min characters.',
        'array'   => ':attribute deve ter pelo menos :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
