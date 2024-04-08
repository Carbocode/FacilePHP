<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__
    ])
    ->name('*.php');

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => [
        'default' => 'align_single_space_minimal',
    ],
    'concat_space' => ['spacing' => 'one'],
    'function_typehint_space' => true,
    'method_argument_space' => [
        'on_multiline' => 'ensure_fully_multiline',
        'keep_multiple_spaces_after_comma' => true,
    ],
    'not_operator_with_successor_space' => true,
    'trim_array_spaces' => true,
    'single_quote' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'blank_line_after_namespace' => true,
    'indentation_type' => true,
])
    ->setFinder($finder);
