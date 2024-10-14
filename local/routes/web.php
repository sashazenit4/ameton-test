<?php

declare(strict_types=1);

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->any('/news/{any}/', new PublicPageController('/news/index.php'))
        ->where('any', '.*');
};
