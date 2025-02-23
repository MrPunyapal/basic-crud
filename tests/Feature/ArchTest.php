<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->security()->ignoring('tempnam');
arch()->preset()->laravel();
