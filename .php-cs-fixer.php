Der Inhalt der .php-cs-fixer.php Konfigurationsdatei hängt von den Regeln ab, die du anwenden möchtest. Sie muss ein PHP-Skript sein, das ein PhpCsFixer\Config Objekt zurückgibt.

Hier ist ein häufig verwendetes Beispiel, das die PSR-12-Standards sowie einige gängige zusätzliche Regeln anwendet:

PHP

<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'braces_position' => [
            'functions_opening_brace' => 'same_line'
        ],
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline' => true,
        'phpdoc_scalar' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => true,
        'blank_line_before_statement' => [
            'statements' => ['return', 'if', 'for', 'foreach', 'do', 'while', 'switch', 'try'],
        ],
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_var_without_name' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        'single_trait_insert_per_statement' => true,
    ])
    ->setFinder($finder);