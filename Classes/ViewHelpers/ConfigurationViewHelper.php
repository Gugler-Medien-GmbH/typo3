<?php

declare(strict_types=1);

namespace CaptchaEU\Typo3\ViewHelpers;

use CaptchaEU\Typo3\Configuration;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ConfigurationViewHelper extends AbstractViewHelper
{
  public function __construct(
    protected Configuration $configuration
  )
  {
  }

  public function render()
  {
    return [
      'host' => $this->configuration->getHost(),
      'keyPublic' => $this->configuration->getKeyPublic(),
      'SDKJSPath' => $this->configuration->getSDKJSPath(),
      'enabled' => $this->configuration->isEnabled()
    ];
  }
}
