<?php

declare(strict_types=1);

use Shopware\Core\Framework\Test\TestCaseBase\KernelLifecycleManager;
use Symfony\Component\Dotenv\Dotenv;

define('TEST_PROJECT_DIR', dirname(__DIR__, 4));

$loader = require TEST_PROJECT_DIR . '/vendor/autoload.php';
KernelLifecycleManager::prepare($loader);
require_once __DIR__ . '/../vendor/autoload.php';

(new Dotenv())->usePutenv()->load(TEST_PROJECT_DIR . '/.env');
