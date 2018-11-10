<?php declare(strict_types=1);

namespace App\Controller\Article;

use App\Controller\AbstractRestController;
use App\Entity\Article;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController.
 */
final class getArticleController extends AbstractRestController
{
    /**
     * @ApiDoc()
     *
     * @FOSRest\View(statusCode=200)
     *
     * @Route(name="get_article", path="/article/{id}", methods={"GET"})
     *
     * @param Article $article
     * @return Article|null
     */
    public function __invoke(Article $article)
    {
        return $article;
    }
}
