<?php

/*
 * This file is part of the NelmioApiDocBundle package.
 *
 * (c) Nelmio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;
use Nelmio\ApiDocBundle\Annotation\Model as Model;
use Nelmio\ApiDocBundle\Exception\RenderInvalidArgumentException;
use Nelmio\ApiDocBundle\Render\Html\AssetsMode;
use Nelmio\ApiDocBundle\Render\RenderOpenApi;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\UserDto;
use App\ResponseRefresh;
use App\RereshBody;
final class TokenController
{
    /**
     * @var RenderOpenApi
     */
    private $renderOpenApi;

    public function __construct(RenderOpenApi $renderOpenApi)
    {
        $this->renderOpenApi = $renderOpenApi;
    }
    /**
     * Refreshes token.
     *
     * Provided a token new refreshed token will be returned.
     *

     * @OA\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=ResponseRefresh::class, ))
     *     )
     * )

     * @OA\RequestBody(@Model(type=RereshBody::class))
     * @OA\Tag(name="registration")
     *
     */
    public function __invoke(Request $request, $area = 'Token')
    {
        try {
            $response = new Response(
                $this->renderOpenApi->renderFromRequest($request, RenderOpenApi::HTML, $area, [
                    'assets_mode' => AssetsMode::BUNDLE,
                ]),

                Response::HTTP_OK,
                ['Content-Type' => 'text/html']
            );

            return $response->setCharset('UTF-8');
        } catch (RenderInvalidArgumentException $e) {
            $advice = '';
            if (false !== strpos($area, '.json')) {
                $advice = ' Since the area provided contains `.json`, the issue is likely caused by route priorities. Try switching the Swagger UI / the json documentation routes order.';
            }

            throw new BadRequestHttpException(sprintf('Area "%s" is not supported as it isn\'t defined in config.%s', $area, $advice), $e);
        }
    }
}
