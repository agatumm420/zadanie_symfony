<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\CookieTokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\QueryParameterTokenExtractor;

class TokenAuthenticator extends JWTAuthenticator
{
    /**
     * @return TokenExtractor\TokenExtractorInterface
     */
    protected function getTokenExtractor():TokenExtractorInterface
    {
        // Return a custom extractor, no matter of what are configured
        return new AuthorizationHeaderTokenExtractor('Bearer', 'Authentication');

        // Or retrieve the chain token extractor for mapping/unmapping extractors for this authenticator
        $chainExtractor = parent::getTokenExtractor();

        // Clear the token extractor map from all configured extractors
        $chainExtractor->clearMap();

        // Or only remove a specific extractor
        $chainTokenExtractor->removeExtractor(function (TokenExtractorInterface $extractor) {
            return $extractor instanceof CookieTokenExtractor;
        });

        // Add a new query parameter extractor to the configured ones
        $chainExtractor->addExtractor(new QueryParameterTokenExtractor('jwt'));

        // Return the chain token extractor with the new map
        return $chainTokenExtractor;
    }
}