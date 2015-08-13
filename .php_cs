<?php
# vi:syntax=php

$header = <<<EOF
This file is part of the Social Feed Util.

(c) LaNetscouade <contact@lanetscouade.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude('spec')
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        'header_comment',
        'long_array_syntax',
        'ordered_use',
        'strict',
        'strict_param',
    ))
    ->finder($finder);
