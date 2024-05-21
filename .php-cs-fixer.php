<?php

declare(strict_types=1);
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())
    ->in(__DIR__)
    ->append(['.php-cs-fixer.php'])
    ->exclude('vendor')
;

return (new Config())
    ->setRules([
        '@PSR12'                          => true,
        '@Symfony'                        => true,
        '@PHPUnit100Migration:risky'      => true,
        'no_trailing_comma_in_singleline' => true,
        'global_namespace_import'         => false,
        'no_superfluous_phpdoc_tags'      => false,
        'concat_space'                    => ['spacing' => 'one'],
        'binary_operator_spaces'          => [
            'operators' => [
                '=>' => 'align_single_space_minimal',
            ],
        ],
        'phpdoc_align' => [
            'align' => 'vertical',
        ],
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
