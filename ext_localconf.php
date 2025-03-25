<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

$iconRegistry = GeneralUtility::makeInstance(
    IconRegistry::class
);

$iconRegistry->registerIcon(
    'captchaeu-icon',
    SvgIconProvider::class,
    [
        'source' => 'EXT:captchaeu_typo3/Resources/Public/Icons/captchaeu-icon.svg'
    ]
);

call_user_func(function(): void {
    ExtensionManagementUtility::addTypoScriptSetup(
        trim('
        plugin.tx_form.settings.yamlConfigurations {
            100 = EXT:captchaeu_typo3/Configuration/Form/CaptchaEUFormSetup.yaml
        }
        module.tx_form.settings.yamlConfigurations {
            100 = EXT:captchaeu_typo3/Configuration/Form/CaptchaEUFormSetup.yaml
        }'));
});
