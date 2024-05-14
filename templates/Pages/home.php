<?php

declare(strict_types=1);

echo file_get_contents(APP_UI . 'index.html');

echo sprintf(
    '<div id="csrf-token" data-csrf-token=%s></div>',
    $this->request->getAttribute('csrfToken')
);
// echo $this->Html->scriptBlock(sprintf(
//     'const csrfToken = %s;',
//     json_encode($this->request->getAttribute('csrfToken'))
// ));
