<?php

declare(strict_types=1);

namespace CaptchaEU\Typo3\Service;

use Exception;
use CaptchaEU\Typo3\Configuration;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Validator
{
  public function __construct(
    protected ClientInterface $client,
    protected LoggerInterface $logger,
    protected Configuration   $configuration
  )
  {
  }

  public function checkSolution($solution, $key, $endpoint)
  {

    $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

    try {
      $payload = [
        'headers' => [
          'Content-Type' => 'application/json',
          'Rest-Key' => $key
        ],
        'body' => $solution
      ];

      $response = $requestFactory->request(
        $endpoint,
        'POST',
        $payload,
      );

      if ($response->getStatusCode() === 200) {
        $result = json_decode($response->getBody()->getContents());
        return $result->success ?? false;
      }

      return false;
    } catch (Exception) {
      return false;
    }
  }

  // validate given solution
  public function validate($solution = '')
  {
    // return if not enabled (eg. keys not set)
    if (!$this->configuration->isEnabled()) {
      return false;
    }

    // solution not set or empty
    if (empty($solution)) {
      return false;
    }
    return $this->checkSolution($solution, $this->configuration->getKeyREST(), $this->configuration->getEPValidate());
  }
}
