<?php declare(strict_types=1);

namespace App\Controller\Article;

use App\Controller\AbstractRestController;
use App\Entity\Article;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class ArticleController.
 */
class ArticleController extends AbstractRestController
{
    /**
     * @ApiDoc()
     *
     * @param ParamFetcherInterface $paramFetcher
     * @FOSRest\QueryParam(name="page", requirements="\d+", default="1")
     *
     * @FOSRest\View()
     */
    public function getArticleListAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->em->getRepository(Article::class)->findAll();
    }
}
